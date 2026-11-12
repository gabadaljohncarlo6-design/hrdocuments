<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>System Information</title>

<link rel="icon" href="../images/isatu_logo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
background:#eef3fb;
font-family:Poppins,sans-serif;
}

.sidebar{
position:fixed;
left:0;
top:0;
width:210px;
height:100vh;
background:#0A2E73;
padding:25px;
}

.sidebar img{
width:90px;
display:block;
margin:auto;
}

.sidebar h3{
color:#fff;
text-align:center;
margin-top:15px;
}

.sidebar p{
color:#ddd;
text-align:center;
margin-bottom:35px;
}

.sidebar a{
display:flex;
align-items:center;
gap:12px;
padding:14px;
margin-bottom:10px;
text-decoration:none;
color:white;
border-radius:10px;
}

.sidebar a:hover{
background:#F5B400;
color:black;
}

.main{
margin-left:210px;
padding:30px;
}

.card{
border:none;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.logo{
width:140px;
display:block;
margin:auto;
margin-bottom:20px;
}

h2{
color:#0A2E73;
font-weight:bold;
}

table td{
padding:10px;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="sidebar">

<a href="dashboard.php" title="Go to Dashboard" style="padding:0;margin:0 auto 4px;background:none;display:block;width:fit-content;text-decoration:none;"><img src="../images/isatu_logo.png"></a>

<h3>ISAT U HRMS</h3>

<p>Administrator Panel</p>

<a href="dashboard.php">
<i class="bi bi-speedometer2"></i>
Dashboard
</a>

<a href="users.php">
<i class="bi bi-people-fill"></i>
Manage Users
</a>
<a href="repository.php">
<i class="bi bi-folder-symlink-fill"></i>
File Repository
</a>

<a href="activity_logs.php">
<i class="bi bi-clock-history"></i>
Activity Logs
</a>

<a href="reports.php">
<i class="bi bi-bar-chart-fill"></i>
Reports
</a>

<a href="system_information.php">
<i class="bi bi-info-circle-fill"></i>
System Information
</a>

<a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</div>

<div class="main">

<div class="card p-5">

<img src="../images/isatu_logo.png" class="logo">

<h2 class="text-center">
ISAT U HR Document Management System
</h2>

<p class="text-center text-muted mb-5">
Human Resource Document Management System
</p>

<table class="table">

<tr>
<td width="220"><strong>System Version</strong></td>
<td>Version 1.0</td>
</tr>

<tr>
<td><strong>Developed By</strong></td>
<td>BS Information Technology Students</td>
</tr>

<tr>
<td><strong>School</strong></td>
<td>Iloilo Science and Technology University</td>
</tr>

<tr>
<td><strong>Campus</strong></td>
<td>Miagao Campus</td>
</tr>

<tr>
<td><strong>Department</strong></td>
<td>Human Resource Office</td>
</tr>

<tr>
<td><strong>Programming Language</strong></td>
<td>PHP 8 / HTML / CSS / JavaScript</td>
</tr>

<tr>
<td><strong>Database</strong></td>
<td>MySQL</td>
</tr>

<tr>
<td><strong>Server</strong></td>
<td>XAMPP</td>
</tr>

<tr>
<td><strong>Academic Year</strong></td>
<td>2026 - 2027</td>
</tr>

<tr>
<td><strong>Description</strong></td>
<td>
The ISAT U Human Resource Document Management System is designed to manage, organize, upload, approve, archive, and monitor faculty documents digitally for the Human Resource Office of Iloilo Science and Technology University - Miagao Campus.
</td>
</tr>

</table>

</div>

</div>

</body>

</html>