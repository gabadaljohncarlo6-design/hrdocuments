<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

// Backfill file_size for any older documents uploaded before this
// feature existed (file_size was NULL). This runs once per file,
// then never again since the DB gets updated.
$missingSizes = mysqli_query($conn, "SELECT document_id, file_path FROM documents WHERE file_size IS NULL");
while ($row = mysqli_fetch_assoc($missingSizes)) {
    if (file_exists($row['file_path'])) {
        $size = filesize($row['file_path']);
        mysqli_query($conn, "UPDATE documents SET file_size = '$size' WHERE document_id = '{$row['document_id']}'");
    }
}

function human_size($bytes) {
    if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . " GB";
    if ($bytes >= 1048576) return round($bytes / 1048576, 2) . " MB";
    if ($bytes >= 1024) return round($bytes / 1024, 2) . " KB";
    return $bytes . " B";
}

$totals = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) AS total_files, COALESCE(SUM(file_size),0) AS total_bytes, COALESCE(AVG(file_size),0) AS avg_bytes
FROM documents
"));

$byCategory = mysqli_query($conn, "
SELECT dc.category_name, COUNT(d.document_id) AS file_count, COALESCE(SUM(d.file_size),0) AS total_bytes
FROM documents d
JOIN document_categories dc ON dc.category_id = d.category_id
GROUP BY dc.category_id
ORDER BY total_bytes DESC
");

$categoryLabels = [];
$categoryData = [];
$categoryRows = [];
while ($row = mysqli_fetch_assoc($byCategory)) {
    $categoryLabels[] = $row['category_name'];
    $categoryData[] = round($row['total_bytes'] / 1048576, 2); // MB
    $categoryRows[] = $row;
}

$byDept = mysqli_query($conn, "
SELECT u.department, COUNT(d.document_id) AS file_count, COALESCE(SUM(d.file_size),0) AS total_bytes
FROM documents d
JOIN users u ON u.user_id = d.user_id
GROUP BY u.department
ORDER BY total_bytes DESC
");

$deptLabels = [];
$deptData = [];
$deptRows = [];
while ($row = mysqli_fetch_assoc($byDept)) {
    $deptLabels[] = $row['department'] ?: 'Unspecified';
    $deptData[] = round($row['total_bytes'] / 1048576, 2); // MB
    $deptRows[] = $row;
}

$largestFiles = mysqli_query($conn, "
SELECT d.document_title, d.file_size, d.submitted_at, u.first_name, u.last_name
FROM documents d
JOIN users u ON u.user_id = d.user_id
ORDER BY d.file_size DESC
LIMIT 10
");

include "includes/header.php";
include "includes/sidebar.php";
?>

<style>
.stat-card{
background:#fff;
border-radius:18px;
padding:22px;
box-shadow:0 10px 30px rgba(0,0,0,.06);
text-align:center;
}
.stat-card h3{
color:#0A2E73;
font-weight:700;
font-size:26px;
margin-bottom:5px;
}
.stat-card p{
color:#888;
font-size:13px;
text-transform:uppercase;
letter-spacing:.5px;
}
.chart-card, .table-card{
background:#fff;
border-radius:18px;
padding:22px;
box-shadow:0 10px 30px rgba(0,0,0,.06);
margin-top:20px;
}
.chart-card h5, .table-card h5{
font-weight:700;
color:#0A2E73;
margin-bottom:15px;
}
</style>

<div class="row g-3 mb-2">

<div class="col-md-4">
<div class="stat-card">
<h3><?php echo $totals['total_files']; ?></h3>
<p>Total Files</p>
</div>
</div>

<div class="col-md-4">
<div class="stat-card">
<h3><?php echo human_size($totals['total_bytes']); ?></h3>
<p>Total Storage Used</p>
</div>
</div>

<div class="col-md-4">
<div class="stat-card">
<h3><?php echo human_size($totals['avg_bytes']); ?></h3>
<p>Average File Size</p>
</div>
</div>

</div>

<div class="row g-3">

<div class="col-md-6">
<div class="chart-card">
<h5><i class="bi bi-pie-chart-fill"></i> Storage by Document Type</h5>
<canvas id="categoryChart" height="220"></canvas>
</div>
</div>

<div class="col-md-6">
<div class="chart-card">
<h5><i class="bi bi-bar-chart-fill"></i> Storage by Department</h5>
<canvas id="deptChart" height="220"></canvas>
</div>
</div>

</div>

<div class="table-card">
<h5><i class="bi bi-files"></i> Storage Breakdown by Document Type</h5>
<div class="table-responsive">
<table class="table table-hover align-middle">
<thead>
<tr><th>Document Type</th><th>Files</th><th>Total Size</th></tr>
</thead>
<tbody>
<?php foreach ($categoryRows as $row): ?>
<tr>
<td><?php echo htmlspecialchars($row['category_name']); ?></td>
<td><?php echo $row['file_count']; ?></td>
<td><?php echo human_size($row['total_bytes']); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

<div class="table-card">
<h5><i class="bi bi-hdd-stack-fill"></i> Largest Files</h5>
<div class="table-responsive">
<table class="table table-hover align-middle">
<thead>
<tr><th>Document Title</th><th>Uploaded By</th><th>Size</th><th>Uploaded</th></tr>
</thead>
<tbody>
<?php if (mysqli_num_rows($largestFiles) === 0): ?>
<tr><td colspan="4" class="text-center text-muted py-4">No documents uploaded yet.</td></tr>
<?php else: while ($f = mysqli_fetch_assoc($largestFiles)): ?>
<tr>
<td><?php echo htmlspecialchars($f['document_title']); ?></td>
<td><?php echo htmlspecialchars($f['first_name'].' '.$f['last_name']); ?></td>
<td><?php echo human_size($f['file_size'] ?? 0); ?></td>
<td><?php echo date("M j, Y", strtotime($f['submitted_at'])); ?></td>
</tr>
<?php endwhile; endif; ?>
</tbody>
</table>
</div>
</div>

<script>
const categoryLabels = <?php echo json_encode($categoryLabels); ?>;
const categoryData = <?php echo json_encode($categoryData); ?>;

const deptLabels = <?php echo json_encode($deptLabels); ?>;
const deptData = <?php echo json_encode($deptData); ?>;

new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: categoryLabels,
        datasets: [{
            data: categoryData,
            backgroundColor: ['#0A2E73','#F5B400','#6B9080','#123C92','#e67e22','#8e44ad','#16a085','#c0392b']
        }]
    },
    options: {
        plugins: {
            tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.raw} MB` } }
        }
    }
});

new Chart(document.getElementById('deptChart'), {
    type: 'bar',
    data: {
        labels: deptLabels,
        datasets: [{
            label: 'Storage Used (MB)',
            data: deptData,
            backgroundColor: '#0A2E73'
        }]
    },
    options: {
        scales: { y: { beginAtZero: true } }
    }
});
</script>

<?php include "includes/footer.php"; ?>