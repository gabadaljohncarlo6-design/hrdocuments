<?php
include 'db.php';

$message = "";
$validToken = false;
$token = isset($_GET['token']) ? $_GET['token'] : (isset($_POST['token']) ? $_POST['token'] : '');

if (!empty($token)) {
    $safeToken = mysqli_real_escape_string($conn, $token);

    $user = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT * FROM users
        WHERE reset_token = '$safeToken'
        AND reset_token_expiry > NOW()
    "));

    if ($user) {
        $validToken = true;
    } else {
        $message = "<div class='alert alert-danger'>This reset link is invalid or has expired. Please request a new one.</div>";
    }
} else {
    $message = "<div class='alert alert-danger'>No reset token provided.</div>";
}

if ($validToken && isset($_POST['reset_password'])) {

    if ($_POST['password'] !== $_POST['confirm_password']) {
        $message = "<div class='alert alert-danger'>Passwords do not match.</div>";
    } elseif (strlen($_POST['password']) < 8) {
        $message = "<div class='alert alert-danger'>Password must be at least 8 characters.</div>";
    } else {
        $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

        mysqli_query($conn, "
            UPDATE users
            SET password = '$hashed', reset_token = NULL, reset_token_expiry = NULL
            WHERE user_id = '{$user['user_id']}'
        ");

        $ip = mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR'] ?? 'unknown');
        mysqli_query($conn, "
            INSERT INTO activity_logs (user_id, activity, module, ip_address)
            VALUES ('{$user['user_id']}', 'Reset password via forgot-password link', 'Authentication', '$ip')
        ");

        $message = "<div class='alert alert-success'>Password reset successfully. You may now <a href='login.php'>log in</a>.</div>";
        $validToken = false; // hide the form after success
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password - ISAT U HR DMS</title>
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
<h3><i class="bi bi-shield-lock-fill"></i> Reset Password</h3>
<p class="sub">Choose a new password for your account.</p>

<?php echo $message; ?>

<?php if ($validToken): ?>
<form method="POST">
<input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

<div class="mb-3">
<input type="password" name="password" class="form-control" placeholder="New password (min. 8 characters)" required minlength="8">
</div>

<div class="mb-3">
<input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" required minlength="8">
</div>

<button type="submit" name="reset_password" class="btn btn-reset">Reset Password</button>
</form>
<?php endif; ?>

<a href="login.php" class="back-link"><i class="bi bi-arrow-left"></i> Back to Login</a>
</div>
<script src="assets/password-toggle.js"></script>
</body>
</html>s