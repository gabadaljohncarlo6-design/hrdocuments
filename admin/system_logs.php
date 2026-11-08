<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>System Logs</title>

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
top:0;
left:0;
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
border-radius:12px;
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

.table thead{
background:#0A2E73;
color:white;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="sidebar">

<img src="../images/isatu_logo.png">

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

<a href="system_logs.php">
<i class="bi bi-journal-text"></i>
System Logs
</a>

<a href="reports.php">
<i class="bi bi-bar-chart-fill"></i>
Reports
</a>

<a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</div>

<div class="main">

<div class="card p-4">

<h2 class="mb-4">

<i class="bi bi-journal-text"></i>

System Logs

</h2>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>ID</th>

<th>User</th>

<th>Role</th>

<th>Activity</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php
$query=mysqli_query($conn,"
SELECT
activity_logs.log_id,
activity_logs.activity,
activity_logs.log_date,
users.first_name,
users.middle_name,
users.last_name,
users.role
FROM activity_logs
INNER JOIN users
ON activity_logs.user_id=users.user_id
ORDER BY activity_logs.log_date DESC
");

while($row=mysqli_fetch_assoc($query))
{

?>

<tr>

<td>

<td><?php echo $row['log_id']; ?></td>

<td>

<?php

echo htmlspecialchars(

$row['first_name']." ".
$row['middle_name']." ".
$row['last_name']

);

?>

</td>

<td>

<?php echo ucfirst($row['role']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['activity']); ?>

</td>

<td>

<?php echo date("F d, Y h:i A",strtotime($row['log_date'])); ?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>