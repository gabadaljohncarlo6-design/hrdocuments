<?php
session_start();
include 'db.php';
include 'includes/mailer.php';
include 'includes/login_verification.php';

$message = "";

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($query) > 0)
    {
        $row = mysqli_fetch_assoc($query);

        if(password_verify($password,$row['password']))
        {
            // Faculty must confirm via an emailed code before logging in
            if($row['role']=="faculty" && lv_start($conn,$row))
            {
                $_SESSION['pending_verify_user_id'] = $row['user_id'];
                header("Location: verify_login.php");
                exit();
            }
            elseif($row['role']=="faculty")
            {
                $message="<div class='alert alert-danger'>We could not send the verification email. Please try again later or contact the HR office.</div>";
            }
            else
            {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['fullname'] = $row['first_name']." ".$row['last_name'];

            $ip = mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR'] ?? 'unknown');
            mysqli_query($conn, "
            INSERT INTO activity_logs (user_id, activity, module, ip_address)
            VALUES ('".$row['user_id']."', 'Logged in', 'Authentication', '$ip')
            ");

            if($row['role']=="admin")
            {
                header("Location: admin/dashboard.php");
                exit();
            }
            elseif($row['role']=="hr")
            {
                header("Location: hr_staff/dashboard.php");
                exit();
            }
            else
            {
                header("Location: faculty/dashboard.php");
                exit();
            }
            }
        }
        else
        {
            $message="<div class='alert alert-danger'>Invalid Password</div>";
        }
    }
    else
    {
        $message="<div class='alert alert-danger'>Account Not Found</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>ISAT U HR Document Management System</title>

<link rel="icon" href="images/isatu_logo.png">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

:root{
    --navy:#0A2E73;
    --navy-soft:#123C92;
    --gold:#F5B400;
    --sage:#6B9080;
    --glass:rgba(255,255,255,.55);
    --glass-border:rgba(255,255,255,.65);
    --ink:#14213A;
}

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{

height:100vh;
overflow:hidden;

background:url("images/isatu_building.jfif");
background-size:cover;
background-position:center;
background-attachment:fixed;
background-repeat:no-repeat;

}

.overlay{

position:fixed;
inset:0;

background:
    linear-gradient(180deg, rgba(7,33,86,.55) 0%, rgba(10,46,115,.16) 40%, rgba(238,243,251,.55) 100%);

}

.container-login{

position:relative;
z-index:10;

height:100vh;

display:flex;

align-items:center;
justify-content:center;

padding:30px;

}

.left-content{

color:white;
padding-right:70px;
text-shadow:0 4px 24px rgba(0,0,0,.35);

}

.left-content .eyebrow{
display:inline-flex;
align-items:center;
gap:8px;
background:rgba(255,255,255,.18);
border:1px solid rgba(255,255,255,.4);
backdrop-filter:blur(12px);
padding:7px 16px;
border-radius:999px;
font-size:12px;
letter-spacing:1.5px;
text-transform:uppercase;
font-weight:500;
margin-bottom:20px;
}

.left-content .eyebrow i{
color:var(--gold);
}

.left-content h1{

font-size:58px;
font-weight:700;

line-height:1.2;

}

.left-content h2{

font-size:30px;
font-weight:300;

margin-top:12px;

}

.left-content p{

margin-top:25px;

font-size:18px;

opacity:.95;

line-height:32px;

}

.login-card{

position:relative;

width:460px;

background:var(--glass);

border-radius:28px;

padding:45px;

box-shadow:0 30px 70px rgba(10,46,115,.25);

backdrop-filter:blur(24px) saturate(160%);
-webkit-backdrop-filter:blur(24px) saturate(160%);

border:1.5px solid var(--glass-border);

overflow:hidden;

}

.login-card::before{
content:"";
position:absolute;
top:0;
left:0;
right:0;
height:5px;
background:linear-gradient(90deg, var(--navy), var(--gold), var(--sage));
}

.logo{

width:120px;

display:block;

margin:auto;

margin-bottom:15px;

}

.login-card h3{

text-align:center;

font-weight:700;

color:var(--navy);

margin-bottom:5px;

}

.login-card h6{

text-align:center;

color:#555;

margin-bottom:25px;

font-weight:400;

}

.form-label{

font-weight:500;
font-size:14px;
color:var(--ink);

}

.form-control{

height:55px;

border-radius:14px;

background:rgba(255,255,255,.7);
border:1.5px solid rgba(10,46,115,.12);
transition:.25s;

}

.form-control:focus{

background:rgba(255,255,255,.95);

border-color:var(--navy);

box-shadow:0 0 0 4px rgba(10,46,115,.12);

}

.btn-login{

height:55px;

background:var(--navy);

border:none;

border-radius:14px;

font-weight:600;

font-size:17px;

color:#fff;

transition:.3s;

box-shadow:0 12px 28px rgba(10,46,115,.3);

}

.btn-login:hover{

background:var(--gold);

color:#000;

transform:translateY(-2px);

box-shadow:0 14px 30px rgba(245,180,0,.35);

}

.register{

text-decoration:none;

font-weight:600;

color:var(--navy);

}

.register:hover{

color:var(--gold);

}

.footer-text{

margin-top:25px;

text-align:center;

font-size:13px;

color:#777;

}

.alert{
border-radius:14px;
border:1px solid transparent;
backdrop-filter:blur(10px);
}

.alert-danger{
background:rgba(255,82,82,.12);
border-color:rgba(255,82,82,.35);
color:#b3261e;
}

@media(max-width:991px){

.left-content{

display:none;

}

.login-card{

width:100%;

max-width:480px;

}

}

</style>

<link rel="stylesheet" href="assets/auth.css">
</head>
<body>

<div class="overlay"></div>

<div class="container container-login">

<div class="row align-items-center w-100">

<div class="col-lg-7">

<div class="left-content">

<span class="eyebrow"><i class="bi bi-stars"></i> Human Resource Document Management</span>

<h1>
Welcome to
</h1>

<h2>
ISAT U HR Document Management System
</h2>

<p>

Secure • Efficient • Paperless

<br><br>

Manage HR documents digitally with a modern, secure and reliable
system designed for the Human Resource Office of
<strong>Iloilo Science and Technology University - Miagao Campus.</strong>

</p>

</div>

</div>

<div class="col-lg-5">

<div class="login-card">

<img
src="images/isatu_logo.png"
class="logo"
alt="ISAT U Logo">

<h3>

ISAT U Miagao

</h3>

<h6>

HR Document Management System

</h6>

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Email Address

</label>

<input
type="email"
name="email"
class="form-control"
placeholder="Enter your email"
required>

</div>

<div class="mb-4">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Enter your password"
required>

<div class="text-end mt-2">
<a href="forgot_password.php" style="font-size:13px;color:var(--navy);text-decoration:none;font-weight:500;">Forgot Password?</a>
</div>

</div>

<button
type="submit"
name="login"
class="btn btn-login w-100">

<i class="bi bi-box-arrow-in-right"></i>

Login

</button>

<div class="text-center mt-4">

Don't have an account?

<br>

<a
href="register.php"
class="register">

Create Account

</a>

</div>

<div class="footer-text">

© <?php echo date("Y"); ?>

Iloilo Science and Technology University

<br>

Miagao Campus

</div>

</form>

</div>

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>