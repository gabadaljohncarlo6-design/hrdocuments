<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$totalUsers=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
"));

$totalDocuments=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM documents
"));

$totalPending=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM documents
WHERE status='Pending'
"));

$totalApproved=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM documents
WHERE status='Approved'
"));
$totalReturned=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM documents
WHERE status='Returned'
"));

$totalRejected=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM documents
WHERE status='Rejected'
"));

$totalFaculty=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
WHERE role='faculty'
"));

$totalHR=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
WHERE role='hr'
"));

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="container-fluid">

<h1 class="fw-bold mb-4">

Dashboard

</h1>
<div class="row g-4 mb-4">

<!-- Registered Users -->
<!-- Registered Users -->
<div class="col-xl-3 col-md-6">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Registered Users</p>
                    <h2 class="fw-bold mb-0"><?php echo $totalUsers['total']; ?></h2>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-people-fill fs-3 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Faculty Users -->
<div class="col-xl-3 col-md-6">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Faculty Users</p>
                    <h2 class="fw-bold mb-0"><?php echo $totalFaculty['total']; ?></h2>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-mortarboard-fill fs-3 text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- HR Users -->
<div class="col-xl-3 col-md-6">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">HR Users</p>
                    <h2 class="fw-bold mb-0"><?php echo $totalHR['total']; ?></h2>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-person-badge-fill fs-3 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Documents -->
<div class="col-xl-3 col-md-6">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">Documents</p>
                    <h2 class="fw-bold mb-0"><?php echo $totalDocuments['total']; ?></h2>
                </div>
                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                    <i class="bi bi-folder-fill fs-3 text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending -->

<div class="col-xl-3 col-md-6">

<div class="card border-0 shadow-sm h-100">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center">

<div>

<p class="text-muted mb-1">

Pending

</p>

<h2 class="fw-bold mb-0">

<?php echo $totalPending['total']; ?>

</h2>

</div>

<div class="rounded-circle bg-danger bg-opacity-10 p-3">

<i class="bi bi-hourglass-split fs-3 text-danger"></i>

</div>

</div>

</div>

</div>

</div>

<!-- Approved -->

<div class="col-xl-3 col-md-6">

<div class="card border-0 shadow-sm h-100">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center">

<div>

<p class="text-muted mb-1">

Approved

</p>

<h2 class="fw-bold mb-0">

<?php echo $totalApproved['total']; ?>

</h2>

</div>

<div class="rounded-circle bg-success bg-opacity-10 p-3">

<i class="bi bi-check-circle-fill fs-3 text-success"></i>

</div>

</div>

</div>

</div>

</div>

</div>

<div class="row g-4 mb-4">

<div class="col-lg-5">
<div class="card border-0 shadow-sm h-100">
<div class="card-header bg-white">
<h5 class="mb-0"><i class="bi bi-pie-chart-fill text-primary"></i> Documents by Status</h5>
</div>
<div class="card-body">
<canvas id="statusChart" height="200"></canvas>
</div>
</div>
</div>

<div class="col-lg-7">
<div class="card border-0 shadow-sm h-100">
<div class="card-header bg-white d-flex justify-content-between align-items-center">
<h5 class="mb-0"><i class="bi bi-clock-history text-primary"></i> Recent Activity</h5>
<a href="activity_logs.php" class="btn btn-primary btn-sm">View All</a>
</div>
<div class="card-body" style="max-height:280px;overflow-y:auto;">

<?php
$recentActivity = mysqli_query($conn, "
SELECT al.*, u.first_name, u.last_name
FROM activity_logs al
LEFT JOIN users u ON u.user_id = al.user_id
ORDER BY al.log_date DESC
LIMIT 8
");

if (mysqli_num_rows($recentActivity) === 0) {
    echo "<p class='text-muted text-center py-4 mb-0'>No activity recorded yet.</p>";
} else {
    echo "<ul class='list-unstyled mb-0'>";
    while ($act = mysqli_fetch_assoc($recentActivity)) {
        $who = $act['first_name'] ? htmlspecialchars($act['first_name'].' '.$act['last_name']) : 'System';
        $when = date("M j, g:i A", strtotime($act['log_date']));
        echo "<li class='d-flex justify-content-between align-items-start py-2 border-bottom'>
            <div>
                <strong>{$who}</strong><br>
                <span class='text-muted' style='font-size:13px;'>" . htmlspecialchars($act['activity']) . "</span>
            </div>
            <small class='text-muted text-nowrap ms-2'>{$when}</small>
        </li>";
    }
    echo "</ul>";
}
?>

</div>
</div>
</div>

</div>

<div class="card border-0 shadow-sm mb-4">

<div class="card-header bg-white d-flex justify-content-between align-items-center">

<h5 class="mb-0">

<i class="bi bi-folder2-open text-primary"></i>

Recent Documents

</h5>

<a href="documents.php" class="btn btn-primary btn-sm">

View All

</a>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-light">

<tr>

<th width="25%">Faculty</th>

<th width="30%">Document</th>

<th width="15%">Status</th>

<th width="20%">Submitted</th>

<th width="10%" class="text-center">View</th>

</tr>

</thead>

<tbody>

<?php

$recentDocuments=mysqli_query($conn,"
SELECT
documents.*,
users.first_name,
users.last_name
FROM documents
LEFT JOIN users
ON documents.user_id=users.user_id
ORDER BY documents.submitted_at DESC
LIMIT 5
");

if(mysqli_num_rows($recentDocuments)>0)
{

while($doc=mysqli_fetch_assoc($recentDocuments))
{

?>

<tr>

<td>

<strong>

<?php

echo htmlspecialchars($doc['first_name']." ".$doc['last_name']);

?>

</strong>

</td>

<td>

<?php

echo htmlspecialchars($doc['document_title']);

?>

</td>

<td>

<?php

switch($doc['status'])
{

case "Pending":

echo "<span class='badge bg-warning text-dark'>Pending</span>";

break;

case "Approved":

echo "<span class='badge bg-success'>Approved</span>";

break;

case "Final Approved":

echo "<span class='badge bg-primary'>Final Approved</span>";

break;

case "Rejected":

echo "<span class='badge bg-danger'>Rejected</span>";

break;

case "Rejected by Admin":

echo "<span class='badge bg-danger'>Rejected by Admin</span>";

break;

case "Archived":

echo "<span class='badge bg-secondary'>Archived</span>";

break;

default:

echo "<span class='badge bg-info'>".$doc['status']."</span>";

}

?>

</td>

<td>

<?php

echo date("M d, Y",strtotime($doc['submitted_at']));

?>

</td>

<td class="text-center">

<a

href="<?php echo htmlspecialchars($doc['file_path']); ?>"

target="_blank"

class="btn btn-sm btn-outline-primary">

<i class="bi bi-eye-fill"></i>

</a>

</td>

</tr>

<?php

}

}

else

{

?>

<tr>

<td colspan="5" class="text-center text-muted">

No documents found.

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

<script>
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Approved', 'Rejected', 'Returned'],
        datasets: [{
            data: [
                <?php echo (int)$totalPending['total']; ?>,
                <?php echo (int)$totalApproved['total']; ?>,
                <?php echo (int)$totalRejected['total']; ?>,
                <?php echo (int)$totalReturned['total']; ?>
            ],
            backgroundColor: ['#F5B400', '#28a745', '#dc3545', '#1f4f56']
        }]
    },
    options: {
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>

<?php include "includes/footer.php"; ?>