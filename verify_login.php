
<?php
session_start();
include 'db.php';
include 'includes/mailer.php';
include 'includes/login_verification.php';

/* ---------- Cancel: go back to the login page ---------- */
if (isset($_GET['cancel'])) {
    unset($_SESSION['pending_verify_user_id']);
    header("Location: login.php");
    exit();
}

/* ---------- Must have just passed the password step ---------- */
if (!isset($_SESSION['pending_verify_user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = (int)$_SESSION['pending_verify_user_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$user || $user['role'] !== 'faculty') {
    unset($_SESSION['pending_verify_user_id']);
    header("Location: login.php");
    exit();
}

$message = "";

/* ---------- Check the code ---------- */
if (isset($_POST['verify'])) {

    $input   = preg_replace('/\D/', '', $_POST['code'] ?? '');
    $pending = lv_get_pending($conn, $userId);

    if (!$pending) {
        $message = "<div class='alert alert-danger'>No active verification code. Please click &quot;Resend Code&quot;.</div>";
    }
    elseif (time() > strtotime($pending['expires_at'])) {
        lv_clear($conn, $userId);
        $message = "<div class='alert alert-danger'>That code has expired. Please click &quot;Resend Code&quot; to get a new one.</div>";
    }
    elseif ((int)$pending['attempts'] >= LV_MAX_ATTEMPTS) {
        $message = "<div class='alert alert-danger'>Too many incorrect attempts. Please click &quot;Resend Code&quot; to get a new one.</div>";
    }
    else {
        // Count this attempt first so it can't be skipped.
        $upd = mysqli_prepare($conn, "UPDATE login_verifications SET attempts = attempts + 1 WHERE user_id = ?");
        mysqli_stmt_bind_param($upd, 'i', $userId);
        mysqli_stmt_execute($upd);
        mysqli_stmt_close($upd);

        if (strlen($input) === 6 && password_verify($input, $pending['code_hash'])) {

            // Verified — now (and only now) create the logged-in session.
            lv_clear($conn, $userId);
            unset($_SESSION['pending_verify_user_id']);
            session_regenerate_id(true);

            $_SESSION['user_id']  = $user['user_id'];
            $_SESSION['role']     = $user['role'];
            $_SESSION['fullname'] = $user['first_name'] . " " . $user['last_name'];

            $ip = mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR'] ?? 'unknown');
            mysqli_query($conn, "
            INSERT INTO activity_logs (user_id, activity, module, ip_address)
            VALUES ('" . (int)$user['user_id'] . "', 'Logged in', 'Authentication', '$ip')
            ");

            header("Location: faculty/dashboard.php");
            exit();
        }

        $left = LV_MAX_ATTEMPTS - ((int)$pending['attempts'] + 1);
        if ($left > 0) {
            $message = "<div class='alert alert-danger'>Incorrect code. You have $left attempt" . ($left === 1 ? "" : "s") . " left.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Too many incorrect attempts. Please click &quot;Resend Code&quot; to get a new one.</div>";
        }
    }
}

/* ---------- Resend a new code ---------- */
if (isset($_POST['resend'])) {

    $pending = lv_get_pending($conn, $userId);
    $wait = 0;
    if ($pending) {
        $wait = LV_RESEND_COOLDOWN - (time() - strtotime($pending['last_sent_at']));
    }

    if ($wait > 0) {
        $message = "<div class='alert alert-danger'>Please wait $wait second" . ($wait === 1 ? "" : "s") . " before requesting another code.</div>";
    }
    elseif (lv_send_code($conn, $user)) {
        $message = "<div class='alert alert-success'>A new verification code has been sent to your email.</div>";
    }
    else {
        $message = "<div class='alert alert-danger'>We could not send the verification email. Please try again later or contact the HR office.</div>";
    }
}

/* ---------- Seconds left before Resend is allowed (for the button) ---------- */
$cooldownLeft = 0;
$current = lv_get_pending($conn, $userId);
if ($current) {
    $cooldownLeft = max(0, LV_RESEND_COOLDOWN - (time() - strtotime($current['last_sent_at'])));
}

$maskedEmail = htmlspecialchars(lv_mask_email($user['email']), ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify Login - ISAT U HR DMS</title>
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
.code-input{text-align:center;font-size:26px;font-weight:600;letter-spacing:10px;}
.btn-reset{height:52px;background:var(--navy);color:#fff;border:none;border-radius:12px;font-weight:600;width:100%;}
.btn-reset:hover{background:var(--gold);color:#000;}
.btn-resend{background:none;border:none;color:var(--navy);font-weight:600;font-size:14px;padding:0;}
.btn-resend:hover:not(:disabled){color:var(--gold);}
.btn-resend:disabled{color:#999;cursor:not-allowed;}
.back-link{display:block;text-align:center;margin-top:18px;color:var(--navy);text-decoration:none;font-weight:600;}
.alert{border-radius:14px;}
</style>
<link rel="stylesheet" href="assets/auth.css">
</head>
<body>
<div class="overlay"></div>
<div class="card-box">
<h3><i class="bi bi-shield-lock-fill"></i> Verify It's You</h3>
<p class="sub">We sent a 6-digit verification code to<br><strong><?php echo $maskedEmail; ?></strong></p>

<?php echo $message; ?>

<form method="POST">
<div class="mb-3">
<input type="text" name="code" class="form-control code-input" placeholder="••••••" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" autocomplete="one-time-code" autofocus required>
</div>
<button type="submit" name="verify" class="btn btn-reset">Verify &amp; Login</button>
</form>

<form method="POST" class="text-center mt-3">
<span style="font-size:14px;color:#666;">Didn't get the code?</span>
<button type="submit" name="resend" id="resendBtn" class="btn-resend" <?php echo $cooldownLeft > 0 ? 'disabled' : ''; ?>>Resend Code</button>
</form>

<a href="verify_login.php?cancel=1" class="back-link"><i class="bi bi-arrow-left"></i> Back to Login</a>
</div>

<script>
(function () {
    var left = <?php echo (int)$cooldownLeft; ?>;
    var btn = document.getElementById('resendBtn');
    if (left > 0) {
        var timer = setInterval(function () {
            left--;
            if (left <= 0) {
                clearInterval(timer);
                btn.disabled = false;
                btn.textContent = 'Resend Code';
            } else {
                btn.textContent = 'Resend Code (' + left + 's)';
            }
        }, 1000);
        btn.textContent = 'Resend Code (' + left + 's)';
    }
})();
</script>
</body>
</html>