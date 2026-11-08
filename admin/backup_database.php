<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "hrdb"; // must match db.php

$date = date("Y-m-d_H-i-s");
$backupFile = "../backup/" . $dbName . "_" . $date . ".sql";

if (!is_dir("../backup")) {
    mkdir("../backup", 0777, true);
}

// mysqldump is often not in the Windows PATH on XAMPP installs,
// so try the common XAMPP location first, then fall back to a bare
// command in case it IS on PATH (e.g. on Linux/Mac XAMPP or MAMP).
$candidates = [
    "C:\\xampp\\mysql\\bin\\mysqldump.exe",
    "mysqldump",
];

$success = false;

foreach ($candidates as $mysqldumpPath) {
    $command = escapeshellarg($mysqldumpPath)
        . " --user=" . escapeshellarg($dbUser)
        . " --password=" . escapeshellarg($dbPass)
        . " " . escapeshellarg($dbName)
        . " > " . escapeshellarg($backupFile)
        . " 2>&1";

    system($command, $result);

    if ($result === 0 && file_exists($backupFile) && filesize($backupFile) > 0) {
        $success = true;
        break;
    }
}

if ($success) {
    $admin_id = (int)$_SESSION['user_id'];
    $fileNameOnly = basename($backupFile);

    mysqli_query($conn, "
    INSERT INTO backup_logs (file_name, action, performed_by)
    VALUES ('$fileNameOnly', 'backup', '$admin_id')
    ");

    mysqli_query($conn, "
    INSERT INTO activity_logs (user_id, activity, module)
    VALUES ('$admin_id', 'Created database backup: $fileNameOnly', 'Database Maintenance')
    ");

    echo "<script>
    alert('Database backup created successfully.');
    window.location='maintinance.php';
    </script>";
} else {
    echo "<script>
    alert('Backup failed. mysqldump could not be found or run. Check that XAMPP is installed at C:\\\\xampp, or that mysqldump is on your system PATH.');
    history.back();
    </script>";
}

?>