<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
include "includes/header.php";
include "includes/sidebar.php";

$result=mysqli_query($conn,"
SELECT *
FROM notifications
ORDER BY created_at DESC
");

?>

<div class="container-fluid">

<h2 class="fw-bold mb-4">

Notifications

</h2>

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

System Notifications

</h5>

</div>

<div class="card-body">

<div class="table-responsive">

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

</div>

<?php include "includes/footer.php"; ?>