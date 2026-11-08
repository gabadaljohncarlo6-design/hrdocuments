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
SELECT
documents.*,
users.first_name,
users.last_name,
document_categories.category_name
FROM documents
LEFT JOIN users
ON users.user_id=documents.user_id
LEFT JOIN document_categories
ON document_categories.category_id=documents.category_id
WHERE documents.is_archived=1
ORDER BY documents.submitted_at DESC
");

?>

<div class="container-fluid">

<h2 class="fw-bold mb-4">

Archived Documents

</h2>

<div class="card shadow border-0">

<div class="card-header bg-secondary text-white">

<h5 class="mb-0">

Archived Files

</h5>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover">

<thead>

<tr>

<th>#</th>

<th>Faculty</th>

<th>Document</th>

<th>Category</th>

<th>Date</th>

<th width="220">Action</th>

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

<td><?php echo htmlspecialchars($row['first_name']." ".$row['last_name']); ?></td>

<td><?php echo htmlspecialchars($row['document_title']); ?></td>

<td><?php echo htmlspecialchars($row['category_name']); ?></td>

<td><?php echo date("F d, Y",strtotime($row['submitted_at'])); ?></td>

<td>
<a href="archive_document_action.php?id=<?php echo $row['document_id']; ?>&restore=1" class="btn btn-sm btn-success" onclick="return confirm('Restore this document back to the main list?')">
<i class="bi bi-arrow-counterclockwise"></i> Restore
</a>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>