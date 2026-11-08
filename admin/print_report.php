<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$result = mysqli_query($conn,"
SELECT
documents.document_title,
document_categories.category_name,
documents.status,
documents.submitted_at,
users.first_name,
users.last_name
FROM documents
LEFT JOIN users
ON documents.user_id=users.user_id
LEFT JOIN document_categories
ON documents.category_id=document_categories.category_id
ORDER BY documents.submitted_at DESC
");
?>

<!DOCTYPE html>

<html>

<head>

<title>ISAT U HRMS Report</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
padding:30px;
font-family:Arial,sans-serif;
}

h2{
text-align:center;
margin-bottom:30px;
}

table{
width:100%;
}

</style>

</head>

<body onload="window.print()">

<div class="text-center">

<img
src="../images/isatu_logo.png"
width="90">

<h2>

ILOILO SCIENCE AND TECHNOLOGY UNIVERSITY

</h2>

<h5>

Miagao Campus

</h5>

<h3>

Human Resource Document Management System

</h3>

<p>

<b>Documents Report</b>

<br>

Generated:
<?php echo date("F d, Y h:i A"); ?>

</p>

</div>

<hr>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>#</th>

<th>Faculty</th>

<th>Document</th>

<th>Category</th>

<th>Status</th>

<th>Submitted</th>

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

<td><?php echo $row['first_name']." ".$row['last_name']; ?></td>

<td><?php echo $row['document_title']; ?></td>

<td><?php echo $row['category_name']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo date("F d, Y",strtotime($row['submitted_at'])); ?></td>

</tr>

<?php

}

?>

</tbody>

</table>

</body>

</html>