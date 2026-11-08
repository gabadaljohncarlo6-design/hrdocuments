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

$status = mysqli_ping($conn) ? "ONLINE" : "OFFLINE";

$db = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT DATABASE() AS dbname
"));

$tables = mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM information_schema.tables
WHERE table_schema = DATABASE()
"))[0];

?>

<div class="container-fluid">

<h2 class="fw-bold mb-4">
Database Status
</h2>

<div class="row">

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body">

<h5>Status</h5>

<h2 class="<?php echo $status=="ONLINE" ? "text-success" : "text-danger"; ?>">
<?php echo $status; ?>
</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body">

<h5>Database</h5>

<h2><?php echo $db['dbname']; ?></h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body">

<h5>Total Tables</h5>

<h2><?php echo $tables; ?></h2>

</div>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>  