<?php
include 'db.php';
include 'includes/mailer.php';

$message = "";

if (isset($_POST['send_reset'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'"));

    // Always show the same message whether or not the email exists,
    // so people can't use this form to find out which emails are registered.
    $message = "<div class='alert alert-success'>
        If that email is registered, a password reset link has been sent to it.
    </div>";

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        mysqli_query($conn, "
        UPDATE users
        SET reset_token = '$token', reset_token_expiry = '$expiry'
        WHERE user_id = '{$user['user_id']}'
        ");

        $resetLink = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=$token";

        $emailBody = "
            <p>Hello {$user['first_name']},</p>
            <p>You requested to reset your password for the ISAT U HR Document Management System.</p>
            <p><a href='$resetLink'>Click here to reset your password</a></p>
            <p>This link expires in 1 hour. If you did not request this, you can safely ignore this email.</p>
            <p>— ISAT U HR Office</p>
        ";

        send_notification_email($conn, $user['email'], $user['first_name'], 'Password Reset Request', $emailBody);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password - ISAT U HR DMS</title>
<link rel="icon" href="images/isatu_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root{--navy:#0A2E73;--gold:#F5B400;}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:url("images/isatu_building.jfif");background-size:cover;background-position:center;background-attachment:fixed;}
.overlay{position:fixed;inset:0;background:linear-gradient(180deg, rgba(7,33,86,.55) 0%, rgba(10,46,115,.16) 40%, rgba(238,243,251,.55) 100%);}
.card-box{position:relative;z-index:10;width:100%;max-width:440px;background:rgba(255,255,255,.9);border-radius:24px;padding:40px;box-shadow:0 30px 70px rgba(10,46,115,.25);}
.card-box h3{color:var(--navy);font-weight:700;text-align:center;margin-bottom:6px;}
.card-box p.sub{text-align:center;color:#666;margin-bottom:24px;font-size:14px;}
.form-control{height:52px;border-radius:12px;}
.btn-reset{height:52px;background:var(--navy);color:#fff;border:none;border-radius:12px;font-weight:600;width:100%;}
.btn-reset:hover{background:var(--gold);color:#000;}
.back-link{display:block;text-align:center;margin-top:18px;color:var(--navy);text-decoration:none;font-weight:600;}
</style>
<link rel="stylesheet" href="assets/auth.css">
</head>
<body>
<div class="overlay"></div>
<div class="card-box">
<h3><i class="bi bi-key-fill"></i> Forgot Password</h3>
<p class="sub">Enter your registered email and we'll send you a reset link.</p>

<?php echo $message; ?>

<form method="POST">
<div class="mb-3">
<input type="email" name="email" class="form-control" placeholder="Enter your registered email" required>
</div>
<button type="submit" name="send_reset" class="btn btn-reset">Send Reset Link</button>
</form>

<a href="login.php" class="back-link"><i class="bi bi-arrow-left"></i> Back to Login</a>
</div>
</body>
</html>