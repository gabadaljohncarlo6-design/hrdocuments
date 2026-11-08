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

About System

</h2>

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

ISAT U Human Resource Management System

</h5>

</div>

<div class="card-body">

<h4>Capstone Project</h4>

<p>

This Human Resource Management System was developed to digitize and manage faculty document submission, approval, tracking, and reporting for the Human Resource Office of Iloilo Science and Technology University.

</p>

<hr>

<h5>Developer</h5>

<p><strong>John Carlo Gabadal</strong></p>

<h5>Course</h5>

<p>Bachelor of Science in Information Technology (BSIT)</p>

<h5>School</h5>

<p>Iloilo Science and Technology University</p>

<h5>Version</h5>

<p>Version 1.0</p>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>