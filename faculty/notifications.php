<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$user_id=$_SESSION['user_id'];

$result=mysqli_query($conn,"
SELECT *
FROM notifications
WHERE user_id='$user_id'
ORDER BY created_at DESC
");

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Notifications</title>

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
max-width:1000px;
margin:40px auto;
}

.card{
border:none;
border-radius:18px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.card-header{
background:#0A2E73;
color:#fff;
padding:20px;
border-radius:18px 18px 0 0 !important;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="container-box">

<div class="card">

<div class="card-header">

<h4 class="mb-0">

<i class="bi bi-bell-fill"></i>

My Notifications

</h4>

</div>

<div class="card-body">

<a href="dashboard.php" class="btn btn-secondary mb-3">

<i class="bi bi-arrow-left"></i>

Back to Dashboard

</a>

<table class="table table-hover">

<thead>

<tr>

<th>#</th>

<th>Message</th>

<th>Status</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php

$i=1;

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $i++; ?></td>

<td><?php echo htmlspecialchars($row['message']); ?></td>

<td>

<?php

if($row['is_read']==0)
{
echo "<span class='badge bg-danger'>Unread</span>";
}
else
{
echo "<span class='badge bg-success'>Read</span>";
}

?>

</td>

<td>

<?php echo date("F d, Y h:i A",strtotime($row['created_at'])); ?>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>