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

body{
background:#eef3fb;
font-family:'Poppins',sans-serif;
}

.container-box{
max-width:700px;
margin:40px auto;
}

.card{
border:none;
border-radius:18px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.card-header{
background:#198754;
color:#fff;
padding:20px;
border-radius:18px 18px 0 0 !important;
}

.card-body{
padding:35px;
}

.form-control{
border-radius:10px;
padding:12px;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="container-box">

<div class="card">

<div class="card-header">

<h3 class="mb-0">

<i class="bi bi-shield-lock-fill"></i>

HR Change Password

</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">
<div class="mb-3">

<label class="form-label">

Current Password

</label>

<input
type="password"
name="current_password"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

New Password

</label>

<input
type="password"
name="new_password"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">

Confirm New Password

</label>

<input
type="password"
name="confirm_password"
class="form-control"
required>

</div>

<div class="d-flex gap-2">

<button
type="submit"
name="change"
class="btn btn-success">

<i class="bi bi-check-circle-fill"></i>

Change Password

</button>

<a
href="dashboard.php"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back to Dashboard

</a>

</div>

</form>

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>