<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr')
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$repo_self = "repository.php";
$repo_profile_url = "faculty_profile.php?id=";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>File Repository</title>
<link rel="icon" href="../images/isatu_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
*{font-family:'Poppins',sans-serif;}
body{background:#eef3fb;}
.sidebar{position:fixed;top:0;left:0;width:110px;height:100vh;background:linear-gradient(180deg,#5b92e5,#2a63bd);padding:16px 8px;overflow-y:auto;overflow-x:hidden;z-index:999;}
.sidebar img{width:44px;display:block;margin:auto;}
.sidebar h3{color:#fff;text-align:center;margin-top:8px;font-weight:700;font-size:12px;line-height:1.2;}
.sidebar p{color:#ddd;text-align:center;margin-bottom:18px;font-size:10px;}
.sidebar a{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;padding:10px 4px;margin-bottom:8px;text-decoration:none;color:#fff;border-radius:12px;transition:.3s;font-weight:500;font-size:10.5px;line-height:1.2;text-align:center;}
.sidebar a i{font-size:18px;}
.sidebar a:hover,.sidebar a.active{background:#F5B400;color:#000;}
.main{margin-left:110px;padding:20px 24px;}
.topbar{background:#fff;padding:12px 20px;border-radius:12px;box-shadow:0 4px 14px rgba(10,46,115,.08);margin-bottom:16px;}
.topbar h2{margin:0;font-weight:700;color:#0A2E73;}
.box{background:#fff;border-radius:12px;padding:18px;box-shadow:0 4px 14px rgba(10,46,115,.08);}
</style>
<link rel="stylesheet" href="../assets/ui.css">
</head>
<body>

<div class="sidebar">
    <img src="../images/isatu_logo.png">
    <h3>ISAT U HRMS</h3>
    <p>HR Staff Panel</p>
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="deadlines.php"><i class="bi bi-calendar-event-fill"></i> Submission Deadlines</a>
    <a href="find_faculty.php"><i class="bi bi-people-fill"></i> Find Faculty</a>
    <a href="repository.php" class="active"><i class="bi bi-folder-symlink-fill"></i> File Repository</a>
    <a href="reports.php"><i class="bi bi-bar-chart-fill"></i> Reports</a>
    <a href="profile.php"><i class="bi bi-person-circle"></i> My Profile</a>
    <a href="change_password.php"><i class="bi bi-key-fill"></i> Change Password</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">

<div class="topbar">
    <h2>File Repository</h2>
    <p class="text-muted mb-0">All files uploaded by faculty and files sent back by HR, in one place.</p>
</div>

<?php include "../includes/repository_core.php"; ?>

</div>
</body>
</html>