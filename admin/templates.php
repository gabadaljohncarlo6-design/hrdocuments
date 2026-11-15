<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$user_id = (int)$_SESSION['user_id'];
$tpl_can_manage = true;

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Template</h2>
        <p class="text-muted mb-0">Upload a file with a title and send it to all faculty users.</p>
    </div>

    <?php include "../includes/templates_core.php"; ?>

</div>

<?php include "includes/footer.php"; ?>