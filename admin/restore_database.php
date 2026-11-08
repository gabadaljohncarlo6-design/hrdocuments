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
$dbName = "hrdb";

$message = "";

if (isset($_POST['restore']) && isset($_FILES['sql_file'])) {

    $ext = strtolower(pathinfo($_FILES['sql_file']['name'], PATHINFO_EXTENSION));

    if ($ext !== 'sql') {
        $message = "<div class='alert alert-danger'>Please upload a valid .sql file.</div>";
    } elseif ($_FILES['sql_file']['error'] !== 0) {
        $message = "<div class='alert alert-danger'>Upload failed. Please try again.</div>";
    } else {

        $tmpPath = $_FILES['sql_file']['tmp_name'];

        $candidates = [
            "C:\\xampp\\mysql\\bin\\mysql.exe",
            "mysql",
        ];

        $success = false;

        foreach ($candidates as $mysqlPath) {
            $command = escapeshellarg($mysqlPath)
                . " --user=" . escapeshellarg($dbUser)
                . " --password=" . escapeshellarg($dbPass)
                . " " . escapeshellarg($dbName)
                . " < " . escapeshellarg($tmpPath)
                . " 2>&1";

            system($command, $result);

            if ($result === 0) {
                $success = true;
                break;
            }
        }

        if ($success) {
            $admin_id = (int)$_SESSION['user_id'];
            $originalName = mysqli_real_escape_string($conn, $_FILES['sql_file']['name']);

            // Reconnect since the restore may have altered/reset tables mid-request
            $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

            mysqli_query($conn, "
            INSERT INTO backup_logs (file_name, action, performed_by)
            VALUES ('$originalName', 'restore', '$admin_id')
            ");

            mysqli_query($conn, "
            INSERT INTO activity_logs (user_id, activity, module)
            VALUES ('$admin_id', 'Restored database from: $originalName', 'Database Maintenance')
            ");

            $message = "<div class='alert alert-success'>Database restored successfully from <strong>" . htmlspecialchars($_FILES['sql_file']['name']) . "</strong>.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Restore failed. Check that XAMPP is installed at C:\\xampp, or that the mysql client is on your system PATH, and that the file is a valid SQL dump.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Restore Database</title>
<link rel="icon" href="../images/isatu_logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#eef3fb;}
.wrap{max-width:700px;margin:60px auto;padding:0 20px;}
.card{border:none;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,.08);padding:35px;}
</style>
<link rel="stylesheet" href="../assets/ui.css">
</head>
<body>

<div class="wrap">
<div class="card">

<h3 class="fw-bold mb-3"><i class="bi bi-database-fill-up"></i> Restore Database</h3>

<div class="alert alert-warning">
<i class="bi bi-exclamation-triangle-fill"></i>
<strong>Warning:</strong> restoring will overwrite existing data in tables included in the SQL file.
Make sure you have a recent backup before proceeding.
</div>

<?php echo $message; ?>

<form method="POST" enctype="multipart/form-data">
<div class="mb-3">
<label class="form-label">Select .sql backup file</label>
<input type="file" name="sql_file" class="form-control" accept=".sql" required>
</div>

<div class="d-flex gap-2">
<button type="submit" name="restore" class="btn btn-danger" onclick="return confirm('This will overwrite existing data. Continue?')">
<i class="bi bi-database-fill-up"></i> Restore Now
</button>
<a href="maintinance.php" class="btn btn-secondary">Cancel</a>
</div>
</form>

</div>
</div>

</body>
</html>