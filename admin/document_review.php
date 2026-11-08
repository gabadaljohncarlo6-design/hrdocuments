<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$document_id = (int)$_GET['id'];

$query = mysqli_query($conn,"
SELECT
documents.*,
users.first_name,
users.middle_name,
users.last_name,
users.employee_id,
users.email,
document_categories.category_name
FROM documents
LEFT JOIN users
ON users.user_id = documents.user_id
LEFT JOIN document_categories
ON document_categories.category_id = documents.category_id
WHERE documents.document_id = $document_id
");

$doc = mysqli_fetch_assoc($query);

$file = $doc['file_path'];
$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">Document Review</h2>

<p class="text-muted">
Review, approve or reject faculty documents.
</p>

</div>

<a href="documents.php" class="btn btn-secondary">
<i class="bi bi-arrow-left"></i> Back
</a>

</div>

<div class="row">

<div class="col-lg-8">

<div class="card shadow-sm border-0">

<div class="card-header bg-white">

<h5 class="mb-0">
<?php echo htmlspecialchars($doc['document_title']); ?>
</h5>

</div>

<div class="card-body">

<div class="card shadow-sm">

<div class="card-header">
<strong>Document Preview</strong>
</div>

<div class="card-body text-center">

<?php if(in_array($extension,['jpg','jpeg','png','gif','webp'])){ ?>

<img
src="<?php echo htmlspecialchars($file); ?>"
class="img-fluid rounded"
style="max-height:700px;">

<?php }elseif($extension=="pdf"){ ?>

<iframe
src="<?php echo htmlspecialchars($file); ?>"
width="100%"
height="700"
style="border:none;">
</iframe>

<?php }else{ ?>

<div class="alert alert-warning">

Preview not available.

<br><br>

<a
href="<?php echo htmlspecialchars($file); ?>"
class="btn btn-primary"
download>

Download File

</a>

</div>

<?php } ?>

</div>

</div>

</div>

</div>

</div>
<div class="col-lg-4">

<div class="card shadow-sm border-0 mb-4">

<div class="card-header bg-white">

<h5 class="mb-0">

Faculty Information

</h5>

</div>

<div class="card-body">

<table class="table table-borderless">

<tr>

<th>Name</th>

<td>

<?php
echo htmlspecialchars(
$doc['first_name']." ".
$doc['middle_name']." ".
$doc['last_name']
);
?>

</td>

</tr>

<tr>

<th>Employee ID</th>

<td>

<?php echo htmlspecialchars($doc['employee_id']); ?>

</td>

</tr>

<tr>

<th>Email</th>

<td>

<?php echo htmlspecialchars($doc['email']); ?>

</td>

</tr>

<tr>

<th>Category</th>

<td>

<?php echo htmlspecialchars($doc['category_name']); ?>

</td>

</tr>

<tr>

<th>Status</th>

<td>

<span class="badge bg-primary">

<?php echo htmlspecialchars($doc['status']); ?>

</span>

</td>

</tr>

<tr>

<th>Submitted</th>

<td>

<?php

echo date(
"F d, Y",
strtotime($doc['submitted_at'])
);

?>

</td>

</tr>

</table>

</div>

</div>
<div class="card shadow-sm border-0">

<div class="card-header bg-white">

<h5 class="mb-0">

Review Status (Read-only)

</h5>

</div>

<div class="card-body">

<div class="alert alert-info mb-3">
<i class="bi bi-info-circle"></i>
Approving, rejecting, or returning documents is handled by HR Staff only. Admin has view access.
</div>

<div class="mb-3">

<label class="form-label">Current Status</label><br>

<span class="badge bg-primary fs-6"><?php echo htmlspecialchars($doc['status']); ?></span>

</div>

<div class="mb-3">

<label class="form-label">HR Remarks</label>

<div class="form-control" style="min-height:120px; background:#f8f9fa;">
<?php echo nl2br(htmlspecialchars($doc['remarks'] ?? '')); ?>
</div>

</div>

</div>

</div>
</div>

</div>

<?php

include "includes/footer.php";

?>