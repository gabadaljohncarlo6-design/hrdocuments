<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$query = mysqli_query($conn,"
SELECT
activity_logs.*,
users.first_name,
users.last_name,
users.role
FROM activity_logs
LEFT JOIN users
ON activity_logs.user_id = users.user_id
ORDER BY activity_logs.log_date DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Activity Logs</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">

<div class="container-fluid">

<span class="navbar-brand">
Activity Logs
</span>

<div>

<a href="dashboard.php"
class="btn btn-primary">

Dashboard

</a>

<a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"
class="btn btn-danger">

Logout

</a>

</div>

</div>

</nav>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>

System Activity Logs

</h4>

</div>

<div class="card-body">

<table class="table table-bordered table-hover table-striped">

<tr>

<th>ID</th>

<th>User</th>

<th>Role</th>

<th>Activity</th>

<th>Date & Time</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($query))
{
?>

<tr>

<td>

<?php echo $row['log_id']; ?>

</td>

<td>

<?php
echo $row['first_name']." ".$row['last_name'];
?>

</td>
<td>

<?php

if($row['role']=="admin")
{
    echo "<span class='badge bg-dark'>Admin</span>";
}
elseif($row['role']=="hr")
{
    echo "<span class='badge bg-success'>HR</span>";
}
else
{
    echo "<span class='badge bg-primary'>Faculty</span>";
}

?>

</td>

<td>

<?php echo $row['activity']; ?>

</td>

<td>

<?php echo $row['log_date']; ?>

</td>

</tr>

<?php
}
?>

</table>

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>