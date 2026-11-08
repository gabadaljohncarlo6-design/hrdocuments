<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";
include "includes/header.php";
include "includes/sidebar.php";
$categoryLabels = [];
$categoryCounts = [];

$result = mysqli_query($conn,"
SELECT
document_categories.category_name,
COUNT(documents.document_id) AS total
FROM document_categories
LEFT JOIN documents
ON document_categories.category_id = documents.category_id
GROUP BY document_categories.category_id
");

while($row = mysqli_fetch_assoc($result))
{
    $categoryLabels[] = $row['category_name'];
    $categoryCounts[] = $row['total'];
}

$monthLabels = [];
$monthCounts = [];

$result = mysqli_query($conn,"
SELECT
DATE_FORMAT(submitted_at,'%b') AS month,
COUNT(*) AS total
FROM documents
GROUP BY MONTH(submitted_at)
ORDER BY MONTH(submitted_at)
");

while($row = mysqli_fetch_assoc($result))
{
    $monthLabels[] = $row['month'];
    $monthCounts[] = $row['total'];
}
$totalUsers = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM users"))[0];
$totalDocuments = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM documents"))[0];
$pending = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM documents WHERE status='Pending'"))[0];
$approved = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM documents WHERE status='Approved'"))[0];
$rejected = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM documents WHERE status='Rejected'"))[0];
$returned = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM documents WHERE status='Returned'"))[0];
$faculty = mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM users
WHERE role='faculty'
"))[0];

$hr = mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM users
WHERE role='hr'
"))[0];

$admin = mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM users
WHERE role='admin'
"))[0];

$returned = mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE status='Returned'
"))[0];
?>

<div class="container-fluid">

<h2 class="fw-bold mb-4">Reports</h2>

<div class="row g-4">

<div class="col-md-4">
<div class="card shadow border-0">
<div class="card-body">
<h6>Total Users</h6>
<h2><?php echo $totalUsers; ?></h2>
</div>
</div>
</div>
<div class="col-md-3">
<div class="card shadow border-0 bg-primary text-white">
<div class="card-body">
<h6>Faculty</h6>
<h2><?php echo $faculty; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-0 bg-success text-white">
<div class="card-body">
<h6>HR Personnel</h6>
<h2><?php echo $hr; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-0 bg-dark text-white">
<div class="card-body">
<h6>Administrators</h6>
<h2><?php echo $admin; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-0 bg-warning">
<div class="card-body">
<h6>Returned</h6>
<h2><?php echo $returned; ?></h2>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card shadow border-0">
<div class="card-body">
<h6>Total Documents</h6>
<h2><?php echo $totalDocuments; ?></h2>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card shadow border-0">
<div class="card-body">
<h6>Pending</h6>
<h2><?php echo $pending; ?></h2>
</div>
</div>
</div>
<div class="col-md-4">
<div class="card shadow border-0">
<div class="card-body">
<h6>Approved</h6>
<h2><?php echo $approved; ?></h2>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card shadow border-0">
<div class="card-body">
<h6>Rejected</h6>
<h2><?php echo $rejected; ?></h2>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card shadow border-0">
<div class="card-body">
<h6>Returned</h6>
<h2><?php echo $returned; ?></h2>
</div>
</div>
</div>

</div>
<div class="row mt-4">

<div class="col-lg-12">

<div class="card shadow border-0">

<div class="card-header bg-dark text-white">

<h5 class="mb-0">

Document Status Distribution

</h5>

</div>

<div class="card-body">

<div style="max-width:350px;margin:auto;">
<canvas id="statusChart"></canvas>
</div>

</div>

</div>

</div>

</div>
<hr class="my-5">
<div class="row mt-4">

<div class="col-lg-6">

<div class="card shadow border-0">

<div class="card-header">

Documents Per Category

</div>

<div class="card-body">

<canvas id="categoryChart"></canvas>

</div>

</div>

</div>

<div class="col-lg-6">

<div class="card shadow border-0">

<div class="card-header">

Monthly Uploads

</div>

<div class="card-body">

<canvas id="monthlyChart"></canvas> 

</div>

</div>

</div>

</div>

<div class="card shadow border-0">
<div class="card-header bg-primary text-white">
<h5 class="mb-0">Quick Reports</h5>
</div>

<div class="card-body">

<a href="print_report.php" target="_blank" class="btn btn-primary">
<i class="bi bi-printer-fill"></i> Print Report
</a>

<a href="export_pdf.php" target="_blank" class="btn btn-success">
<i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
</a>

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
                <?php echo (int)$pending; ?>,
                <?php echo (int)$approved; ?>,
                <?php echo (int)$rejected; ?>,
                <?php echo (int)$returned; ?>
            ],
            backgroundColor: ['#F5B400', '#28a745', '#dc3545', '#17a2b8']
        }]
    },
    options: {
        plugins: {
            legend: { position: 'bottom' }
        }
    }

});

new Chart(document.getElementById('categoryChart'), {

    type: 'bar',

    data: {
        labels: <?php echo json_encode($categoryLabels); ?>,
        datasets: [{
            label: 'Documents',
            data: <?php echo json_encode($categoryCounts); ?>,
            backgroundColor: [
                '#0d6efd',
                '#198754',
                '#ffc107',
                '#dc3545',
                '#6f42c1'
            ]
        }]
    },

    options: {
        responsive: true
    }

});

new Chart(document.getElementById('monthlyChart'), {

    type: 'line',

    data: {
        labels: <?php echo json_encode($monthLabels); ?>,
        datasets: [{
            label: 'Uploads',
            data: <?php echo json_encode($monthCounts); ?>,
            fill: false,
            borderColor: '#0d6efd',
            tension: 0.3
        }]
    },

    options: {
        responsive: true
    }

});
</script>
<?php
include "includes/footer.php";
?>