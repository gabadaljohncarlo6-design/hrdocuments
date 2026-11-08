<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$repo_self = "repository.php";
$repo_profile_url = "faculty_profile.php?id=";

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">File Repository</h2>
        <p class="text-muted mb-0">All files uploaded by faculty and files sent back by HR Staff.</p>
    </div>

    <?php include "../includes/repository_core.php"; ?>

</div>

<?php include "includes/footer.php"; ?>