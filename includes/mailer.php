<?php
/**
 * SimpleMailer — minimal SMTP client for sending email via Gmail.
 * No external libraries required. Works with a Gmail "App Password"
 * (not your normal Gmail password — see setup notes below).
 *
 * SETUP (one-time, in Gmail):
 * 1. Enable 2-Step Verification on the Gmail account you want to send from.
 * 2. Go to https://myaccount.google.com/apppasswords
 * 3. Create an App Password for "Mail" → copy the 16-character code.
 * 4. Enter that Gmail address + the 16-character code in
 *    Admin > System Settings (smtp_username / smtp_app_password).
 */

class SimpleMailer
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $fromEmail;
    private $fromName;
    private $socket;
    private $lastError = '';

    public function __construct($host, $port, $username, $password, $fromName = 'ISAT U HR DMS')
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->fromEmail = $username;
        $this->fromName = $fromName;
    }

    public function getLastError()
    {
        return $this->lastError;
    }

    private function readResponse()
    {
        $data = '';
        while ($line = fgets($this->socket, 515)) {
            $data .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }
        return $data;
    }

    private function command($cmd)
    {
        fwrite($this->socket, $cmd . "\r\n");
        return $this->readResponse();
    }

    public function connect()
    {
        $this->socket = @stream_socket_client(
            "tcp://{$this->host}:{$this->port}",
            $errno,
            $errstr,
            15,
            STREAM_CLIENT_CONNECT
        );

        if (!$this->socket) {
            $this->lastError = "Connection failed: $errstr ($errno)";
            return false;
        }

        $this->readResponse();
        $this->command("EHLO localhost");

        $resp = $this->command("STARTTLS");
        if (strpos($resp, '220') !== 0) {
            $this->lastError = "STARTTLS failed: $resp";
            return false;
        }

        if (!stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            $this->lastError = "TLS handshake failed";
            return false;
        }

        $this->command("EHLO localhost");

        $resp = $this->command("AUTH LOGIN");
        if (strpos($resp, '334') !== 0) {
            $this->lastError = "AUTH LOGIN not accepted: $resp";
            return false;
        }

        $resp = $this->command(base64_encode($this->username));
        if (strpos($resp, '334') !== 0) {
            $this->lastError = "Username rejected: $resp";
            return false;
        }

        $resp = $this->command(base64_encode($this->password));
        if (strpos($resp, '235') !== 0) {
            $this->lastError = "Authentication failed (check App Password): $resp";
            return false;
        }

        return true;
    }

    public function send($toEmail, $toName, $subject, $htmlBody)
    {
        if (!$this->socket) {
            $this->lastError = "Not connected";
            return false;
        }

        $resp = $this->command("MAIL FROM:<{$this->fromEmail}>");
        if (strpos($resp, '250') !== 0) {
            $this->lastError = "MAIL FROM rejected: $resp";
            return false;
        }

        $resp = $this->command("RCPT TO:<{$toEmail}>");
        if (strpos($resp, '250') !== 0) {
            $this->lastError = "RCPT TO rejected for $toEmail: $resp";
            return false;
        }

        $resp = $this->command("DATA");
        if (strpos($resp, '354') !== 0) {
            $this->lastError = "DATA command rejected: $resp";
            return false;
        }

        $headers = "From: {$this->fromName} <{$this->fromEmail}>\r\n";
        $headers .= "To: {$toName} <{$toEmail}>\r\n";
        $headers .= "Subject: {$subject}\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "\r\n";

        // Escape lines starting with a lone "." per SMTP spec
        $body = preg_replace('/^\./m', '..', $htmlBody);

        $resp = $this->command($headers . $body . "\r\n.");
        if (strpos($resp, '250') !== 0) {
            $this->lastError = "Message not accepted: $resp";
            return false;
        }

        return true;
    }

    public function close()
    {
        if ($this->socket) {
            $this->command("QUIT");
            fclose($this->socket);
            $this->socket = null;
        }
    }
}

/**
 * Helper: send one email using the SMTP settings stored in system_settings.
 * Returns true on success, false on failure. Never throws — always safe
 * to call from anywhere without crashing the calling page.
 *
 * $conn must be an active mysqli connection.
 */
function send_notification_email($conn, $toEmail, $toName, $subject, $htmlBody)
{
    $settings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM system_settings LIMIT 1"));

    if (!$settings || empty($settings['smtp_username']) || empty($settings['smtp_app_password'])) {
        error_log("Email not sent: SMTP not configured in system_settings.");
        return false;
    }

    $mailer = new SimpleMailer(
        $settings['smtp_host'] ?: 'smtp.gmail.com',
        $settings['smtp_port'] ?: 587,
        $settings['smtp_username'],
        $settings['smtp_app_password']
    );

    if (!$mailer->connect()) {
        error_log("Email connect failed: " . $mailer->getLastError());
        return false;
    }

    $result = $mailer->send($toEmail, $toName, $subject, $htmlBody);

    if (!$result) {
        error_log("Email send failed to $toEmail: " . $mailer->getLastError());
    }

    $mailer->close();
    return $result;
}

/**
 * Helper: send the same email to a list of recipients using ONE connection
 * (much faster than reconnecting per recipient). Returns an array of
 * ['email' => bool_success] for each recipient.
 */
function send_bulk_notification_email($conn, array $recipients, $subject, $htmlBody)
{
    $results = [];

    $settings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM system_settings LIMIT 1"));

    if (!$settings || empty($settings['smtp_username']) || empty($settings['smtp_app_password'])) {
        error_log("Bulk email not sent: SMTP not configured in system_settings.");
        foreach ($recipients as $r) {
            $results[$r['email']] = false;
        }
        return $results;
    }

    $mailer = new SimpleMailer(
        $settings['smtp_host'] ?: 'smtp.gmail.com',
        $settings['smtp_port'] ?: 587,
        $settings['smtp_username'],
        $settings['smtp_app_password']
    );

    if (!$mailer->connect()) {
        error_log("Bulk email connect failed: " . $mailer->getLastError());
        foreach ($recipients as $r) {
            $results[$r['email']] = false;
        }
        return $results;
    }

    foreach ($recipients as $r) {
        $ok = $mailer->send($r['email'], $r['name'], $subject, $htmlBody);
        $results[$r['email']] = $ok;
        if (!$ok) {
            error_log("Bulk email failed for {$r['email']}: " . $mailer->getLastError());
        }
    }

    $mailer->close();
    return $results;
}