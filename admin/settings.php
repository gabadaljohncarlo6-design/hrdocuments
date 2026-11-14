<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
include "../includes/mailer.php";

$message="";

$settings=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT *
FROM system_settings
LIMIT 1
"));

if(isset($_POST['save']))
{

    $system_name=mysqli_real_escape_string($conn,$_POST['system_name']);
    $school_name=mysqli_real_escape_string($conn,$_POST['school_name']);
    $campus=mysqli_real_escape_string($conn,$_POST['campus']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);
    $new_password=$_POST['password'];

    $smtp_host=mysqli_real_escape_string($conn,$_POST['smtp_host']);
    $smtp_port=(int)$_POST['smtp_port'];
    $smtp_username=mysqli_real_escape_string($conn,$_POST['smtp_username']);

    // Only update the app password if a new one was actually typed,
    // so the field can stay blank on reload without wiping it out.
    $smtp_password_sql = "";
    if (!empty($_POST['smtp_app_password'])) {
        $smtp_app_password = mysqli_real_escape_string($conn, $_POST['smtp_app_password']);
        $smtp_password_sql = ",smtp_app_password='$smtp_app_password'";
    }

    if(!empty($new_password))
    {
        $hashed_password=password_hash($new_password,PASSWORD_DEFAULT);

        mysqli_query($conn,"
        UPDATE users
        SET password='$hashed_password'
        WHERE user_id='".$_SESSION['user_id']."'
        ");
    }

    mysqli_query($conn,"
    UPDATE system_settings
    SET
    system_name='$system_name',
    school_name='$school_name',
    campus='$campus',
    official_email='$email',
    smtp_host='$smtp_host',
    smtp_port='$smtp_port',
    smtp_username='$smtp_username'
    $smtp_password_sql
    WHERE id=1
    ");

    $settings=mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT *
    FROM system_settings
    LIMIT 1
    "));

    $message="<div class='alert alert-success'>
    Settings Saved Successfully.
    </div>";
}

if (isset($_POST['send_test_email'])) {

    if (empty($settings['smtp_username']) || empty($settings['smtp_app_password'])) {
        $message = "<div class='alert alert-danger'>
        Please save your Gmail address and App Password first.
        </div>";
    } else {
        $sent = send_notification_email(
            $conn,
            $settings['smtp_username'],
            'Admin',
            'ISAT U HR DMS - Test Email',
            '<p>This is a test email from your ISAT U HR Document Management System. If you received this, email notifications are working correctly.</p>'
        );

        $message = $sent
            ? "<div class='alert alert-success'>Test email sent successfully to {$settings['smtp_username']}. Check the inbox.</div>"
            : "<div class='alert alert-danger'>Test email failed to send. Double check the Gmail address and App Password (must be a 16-character App Password, not your normal Gmail password).<br><small><b>Reason:</b> " . htmlspecialchars($GLOBALS['mail_last_error'] ?? 'Unknown error') . "</small></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>System Settings</title>

<link rel="icon" href="../images/isatu_logo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}

body{
background:#eef3fb;
overflow-x:hidden;
}

.sidebar{
position:fixed;
top:0;
left:0;
width:110px;
height:100vh;
background:linear-gradient(180deg,#0A2E73,#123c92);
padding:16px 8px;
overflow-y:auto;
overflow-x:hidden;
z-index:999;
}

.sidebar img{
width:44px;
display:block;
margin:auto;
}

.sidebar h3{
color:#fff;
text-align:center;
margin-top:8px;
font-weight:700;
font-size:12px;
line-height:1.2;
}

.sidebar p{
color:#ddd;
text-align:center;
margin-bottom:18px;
font-size:10px;
}

.sidebar a{
display:flex;
flex-direction:column;
align-items:center;
justify-content:center;
gap:4px;
padding:10px 4px;
margin-bottom:8px;
text-decoration:none;
color:#fff;
border-radius:12px;
transition:.3s;
font-weight:500;
font-size:10.5px;
line-height:1.2;
text-align:center;
word-break:break-word;
white-space:normal;
}

.sidebar a i{
font-size:18px;
}

.sidebar a:hover{
background:#F5B400;
color:#000;
}

.sidebar a.active{
background:#F5B400;
color:#000;
}

.main{
margin-left:110px;
padding:30px;
}

.card{
border:none;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.btn-save{
background:#0A2E73;
color:white;
}

.btn-save:hover{
background:#F5B400;
color:black;
}

.section-title{
font-weight:700;
color:#0A2E73;
margin-top:10px;
margin-bottom:15px;
padding-bottom:8px;
border-bottom:2px solid #eef3fb;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="sidebar">

<a href="dashboard.php" title="Go to Dashboard" style="padding:0;margin:0 auto 4px;background:none;display:block;width:fit-content;text-decoration:none;"><img src="../images/isatu_logo.png"></a>

<h3>ISAT U HRMS</h3>

<p>Administrator Panel</p>

<a href="dashboard.php"><i class="bi bi-speedometer2"></i>Dashboard</a>

<a href="users.php"><i class="bi bi-people-fill"></i>Manage Users</a>
<a href="repository.php"><i class="bi bi-folder-symlink-fill"></i>File Repository</a>

<a href="activity_logs.php"><i class="bi bi-clock-history"></i>Activity Logs</a>

<a href="reports.php"><i class="bi bi-bar-chart-fill"></i>Reports</a>

<a href="settings.php" class="active"><i class="bi bi-gear-fill"></i>Settings</a>

<a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"><i class="bi bi-box-arrow-right"></i>Logout</a>

</div>

<div class="main">

<a href="dashboard.php" class="btn btn-secondary mb-3">
<i class="bi bi-arrow-left"></i> Back
</a>

<div class="card p-5">

<h2 class="mb-4">

<i class="bi bi-gear-fill"></i>

System Settings

</h2>

<?php echo $message; ?>

<form method="POST">

<div class="section-title">General</div>

<div class="mb-3">
<label class="form-label">System Name</label>
<input type="text" name="system_name" class="form-control"
value="<?php echo htmlspecialchars($settings['system_name']); ?>">
</div>

<div class="mb-3">
<label class="form-label">School Name</label>
<input type="text" name="school_name" class="form-control"
value="<?php echo htmlspecialchars($settings['school_name']); ?>">
</div>

<div class="mb-3">
<label class="form-label">Campus</label>
<input type="text" name="campus" class="form-control"
value="<?php echo htmlspecialchars($settings['campus']); ?>">
</div>

<div class="mb-3">
<label class="form-label">Official Email</label>
<input type="email" name="email" class="form-control"
value="<?php echo htmlspecialchars($settings['official_email']); ?>">
</div>

<div class="mb-4">
<label class="form-label">Administrator Password</label>
<input type="password" name="password" class="form-control"
placeholder="Leave blank if you don't want to change your password">
</div>

<div class="section-title">Email Notifications (Gmail SMTP)</div>
<p class="text-muted" style="font-size:13px;margin-top:-10px;margin-bottom:15px;">
This Gmail account sends deadline reminders and status update emails to faculty.
You need a Gmail <strong>App Password</strong> (not your normal password) —
generate one at
<a href="https://myaccount.google.com/apppasswords" target="_blank">myaccount.google.com/apppasswords</a>
after enabling 2-Step Verification.
</p>

<div class="row">
<div class="col-md-6 mb-3">
<label class="form-label">SMTP Host</label>
<input type="text" name="smtp_host" class="form-control"
value="<?php echo htmlspecialchars($settings['smtp_host'] ?: 'smtp.gmail.com'); ?>">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">SMTP Port</label>
<input type="number" name="smtp_port" class="form-control"
value="<?php echo htmlspecialchars($settings['smtp_port'] ?: 587); ?>">
</div>
</div>

<div class="mb-3">
<label class="form-label">Sending Gmail Address</label>
<input type="email" name="smtp_username" class="form-control"
placeholder="yourhroffice@gmail.com"
value="<?php echo htmlspecialchars($settings['smtp_username'] ?? ''); ?>">
</div>

<div class="mb-4">
<label class="form-label">Gmail App Password</label>
<input type="password" name="smtp_app_password" class="form-control"
placeholder="<?php echo !empty($settings['smtp_app_password']) ? 'Already set — leave blank to keep it' : '16-character App Password'; ?>">
</div>

<div class="d-flex gap-2">

<button type="submit" name="save" class="btn btn-save">
<i class="bi bi-floppy-fill"></i>
Save Settings
</button>

<button type="submit" name="send_test_email" class="btn btn-outline-primary">
<i class="bi bi-envelope-check-fill"></i>
Send Test Email
</button>

</div>

</form>

</div>

</div>

<script src="../assets/password-toggle.js"></script>
</body>

</html>