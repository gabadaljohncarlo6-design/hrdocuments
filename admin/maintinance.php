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

?>

<div class="container-fluid">

<h2 class="fw-bold mb-4">

System Maintenance

</h2>

<div class="card shadow border-0">

<div class="card-header bg-warning">

<h5 class="mb-0">

Maintenance Tools

</h5>

</div>

<div class="card-body">

<a href="backup_database.php" class="btn btn-primary m-2">
<i class="bi bi-database-fill-down"></i>
Backup Database
</a>

<a href="restore_database.php" class="btn btn-danger m-2">
<i class="bi bi-database-fill-up"></i>
Restore Database
</a>

<a href="database_status.php" class="btn btn-success m-2">
<i class="bi bi-server"></i>
Database Status
</a>

<a href="system_logs.php" class="btn btn-dark m-2">
<i class="bi bi-journal-text"></i>
System Logs
</a>

<a href="system_information.php" class="btn btn-info text-white m-2">
<i class="bi bi-info-circle-fill"></i>
System Information
</a>

</div>

</div>

<div class="card shadow border-0 mt-4">

<div class="card-header bg-secondary text-white">
<h5 class="mb-0"><i class="bi bi-archive-fill"></i> Backup History</h5>
</div>

<div class="card-body">

<?php
$backupDir = "../backup/";
$backupFiles = [];

if (is_dir($backupDir)) {
    foreach (scandir($backupDir) as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
            $backupFiles[] = [
                'name' => $file,
                'size' => filesize($backupDir . $file),
                'time' => filemtime($backupDir . $file),
            ];
        }
    }
    usort($backupFiles, function($a, $b) { return $b['time'] - $a['time']; });
}
?>

<?php if (empty($backupFiles)): ?>
<p class="text-muted mb-0">No backups created yet. Click "Backup Database" above to create one.</p>
<?php else: ?>
<div class="table-responsive">
<table class="table table-hover align-middle">
<thead>
<tr>
<th>File Name</th>
<th>Size</th>
<th>Created</th>
<th width="120">Download</th>
</tr>
</thead>
<tbody>
<?php foreach ($backupFiles as $bf): ?>
<tr>
<td><?php echo htmlspecialchars($bf['name']); ?></td>
<td><?php echo round($bf['size'] / 1024, 1); ?> KB</td>
<td><?php echo date("M j, Y g:i A", $bf['time']); ?></td>
<td>
<a href="../backup/<?php echo urlencode($bf['name']); ?>" class="btn btn-sm btn-outline-primary" download>
<i class="bi bi-download"></i>
</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php endif; ?>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>