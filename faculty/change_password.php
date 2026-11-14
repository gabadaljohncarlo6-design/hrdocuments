<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$user_id=$_SESSION['user_id'];

$message="";

if(isset($_POST['change']))
{

    $current=$_POST['current_password'];

    $new=$_POST['new_password'];

    $confirm=$_POST['confirm_password'];

    $user=mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT password
    FROM users
    WHERE user_id='$user_id'
    "));

    if(password_verify($current,$user['password']))
    {

        if($new==$confirm)
        {

            $hashed=password_hash($new,PASSWORD_DEFAULT);

            mysqli_query($conn,"
            UPDATE users
            SET password='$hashed'
            WHERE user_id='$user_id'
            ");

            mysqli_query($conn, "
            INSERT INTO activity_logs (user_id, activity, module)
            VALUES ('$user_id', 'Changed own password', 'Authentication')
            ");

            $message="
            <div class='alert alert-success'>
            Password changed successfully.
            </div>";

        }
        else
        {

            $message="
            <div class='alert alert-danger'>
            New passwords do not match.
            </div>";

        }

    }
    else
    {

        $message="
        <div class='alert alert-danger'>
        Current password is incorrect.
        </div>";

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Password</title>
<link rel="icon" href="../images/isatu_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#eef3fb;}
.card{border:none;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,.08);}
.btn-save{background:#0A2E73;color:#fff;}
.btn-save:hover{background:#F5B400;color:#000;}
</style>
<link rel="stylesheet" href="../assets/ui.css">
</head>
<body>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-lg-6">

<a href="dashboard.php" class="btn btn-secondary mb-3">
<i class="bi bi-arrow-left"></i> Back
</a>

<div class="card p-4">

<h3 class="fw-bold mb-4 text-center"><i class="bi bi-key-fill"></i> Change Password</h3>

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label class="form-label">Current Password</label>
<input type="password" name="current_password" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">New Password</label>
<input type="password" name="new_password" class="form-control" required minlength="8">
</div>

<div class="mb-4">
<label class="form-label">Confirm New Password</label>
<input type="password" name="confirm_password" class="form-control" required minlength="8">
</div>

<button type="submit" name="change" class="btn btn-save w-100">
<i class="bi bi-check-circle-fill"></i> Update Password
</button>

</form>

</div>

</div>

</div>

</div>

<script src="../assets/password-toggle.js"></script>
</body>
</html>