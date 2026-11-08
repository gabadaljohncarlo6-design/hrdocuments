<?php
/**
 * Faculty login verification (email one-time code).
 *
 * After a faculty member enters the correct password, a 6-digit code is
 * emailed to the address on their account. They only get logged in once
 * they enter that code on verify_login.php.
 *
 * Uses the existing Gmail/SMTP settings (Admin > System Settings) via
 * includes/mailer.php. The table below is created automatically the first
 * time it is needed, so no manual database step is required.
 */

const LV_CODE_TTL        = 600; // code is valid for 10 minutes
const LV_MAX_ATTEMPTS    = 5;   // wrong guesses allowed per code
const LV_RESEND_COOLDOWN = 60;  // seconds before a new code can be requested

/**
 * Create the table that stores pending verification codes (if missing).
 */
function lv_ensure_table($conn)
{
    mysqli_query($conn, "
        CREATE TABLE IF NOT EXISTS login_verifications (
            id INT(11) NOT NULL AUTO_INCREMENT,
            user_id INT(11) NOT NULL,
            code_hash VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            attempts INT(11) NOT NULL DEFAULT 0,
            last_sent_at DATETIME NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY uq_login_verifications_user (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    ");
}

/**
 * Generate a fresh code for this user, store only its hash, and email it.
 * Any earlier code for the same user is replaced.
 *
 * $user must contain: user_id, first_name, email
 * Returns true if the email was sent, false otherwise.
 */
function lv_send_code($conn, array $user)
{
    lv_ensure_table($conn);

    $userId = (int)$user['user_id'];
    $code   = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $hash   = password_hash($code, PASSWORD_DEFAULT);
    $now    = date('Y-m-d H:i:s');
    $expiry = date('Y-m-d H:i:s', time() + LV_CODE_TTL);

    $del = mysqli_prepare($conn, "DELETE FROM login_verifications WHERE user_id = ?");
    mysqli_stmt_bind_param($del, 'i', $userId);
    mysqli_stmt_execute($del);
    mysqli_stmt_close($del);

    $ins = mysqli_prepare($conn, "
        INSERT INTO login_verifications (user_id, code_hash, expires_at, attempts, last_sent_at)
        VALUES (?, ?, ?, 0, ?)
    ");
    mysqli_stmt_bind_param($ins, 'isss', $userId, $hash, $expiry, $now);
    $stored = mysqli_stmt_execute($ins);
    mysqli_stmt_close($ins);

    if (!$stored) {
        return false;
    }

    $name  = htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8');
    $mins  = (int)(LV_CODE_TTL / 60);
    $body  = "
        <p>Hello {$name},</p>
        <p>Someone is trying to log in to your account on the ISAT U HR Document Management System.
        To confirm that it is really you, enter this verification code:</p>
        <p style='font-size:30px;font-weight:bold;letter-spacing:8px;color:#0A2E73;margin:18px 0;'>{$code}</p>
        <p>This code expires in {$mins} minutes. If you did not try to log in,
        do not share this code with anyone and consider changing your password.</p>
        <p>— ISAT U HR Office</p>
    ";

    $sent = send_notification_email($conn, $user['email'], $user['first_name'], 'Your Login Verification Code', $body);

    if (!$sent) {
        // Don't leave a code behind that nobody received.
        $cleanup = mysqli_prepare($conn, "DELETE FROM login_verifications WHERE user_id = ?");
        mysqli_stmt_bind_param($cleanup, 'i', $userId);
        mysqli_stmt_execute($cleanup);
        mysqli_stmt_close($cleanup);
        return false;
    }

    return true;
}

/**
 * Start verification right after a correct password.
 * If a still-valid code was emailed less than a minute ago (for example the
 * person went back to the login page and logged in again), don't send
 * another one — just let them enter the existing code.
 */
function lv_start($conn, array $user)
{
    $pending = lv_get_pending($conn, $user['user_id']);

    if ($pending
        && time() - strtotime($pending['last_sent_at']) < LV_RESEND_COOLDOWN
        && time() <= strtotime($pending['expires_at'])) {
        return true;
    }

    return lv_send_code($conn, $user);
}

/**
 * Fetch the pending verification row for a user (or null).
 */
function lv_get_pending($conn, $userId)
{
    lv_ensure_table($conn);

    $userId = (int)$userId;
    $stmt = mysqli_prepare($conn, "SELECT * FROM login_verifications WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    return $row ?: null;
}

/**
 * Remove any pending code for a user.
 */
function lv_clear($conn, $userId)
{
    $userId = (int)$userId;
    $stmt = mysqli_prepare($conn, "DELETE FROM login_verifications WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/**
 * m*****l@gmail.com — shown on the verification page.
 */
function lv_mask_email($email)
{
    $parts = explode('@', $email, 2);
    if (count($parts) !== 2) {
        return $email;
    }
    $local = $parts[0];
    $len   = strlen($local);
    $masked = $len <= 2
        ? substr($local, 0, 1) . str_repeat('*', max($len - 1, 1))
        : substr($local, 0, 1) . str_repeat('*', $len - 2) . substr($local, -1);

    return $masked . '@' . $parts[1];
}