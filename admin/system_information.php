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

<h2 class="fw-bold mb-4">System Information</h2>

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">
<h5 class="mb-0">ISAT U HR Document Management System</h5>
</div>

<div class="card-body">

<table class="table">

<tr>
<td width="220"><strong>System Version</strong></td>
<td>Version 1.0</td>
</tr>

<tr>
<td><strong>Developed By</strong></td>
<td>BS Information Technology Students</td>
</tr>

<tr>
<td><strong>School</strong></td>
<td>Iloilo Science and Technology University</td>
</tr>

<tr>
<td><strong>Campus</strong></td>
<td>Miagao Campus</td>
</tr>

<tr>
<td><strong>Department</strong></td>
<td>Human Resource Office</td>
</tr>

<tr>
<td><strong>Programming Language</strong></td>
<td>PHP 8 / HTML / CSS / JavaScript</td>
</tr>

<tr>
<td><strong>Database</strong></td>
<td>MySQL</td>
</tr>

<tr>
<td><strong>Server</strong></td>
<td>XAMPP</td>
</tr>

<tr>
<td><strong>Academic Year</strong></td>
<td>2026 - 2027</td>
</tr>

<tr>
<td><strong>Description</strong></td>
<td>
The ISAT U Human Resource Document Management System is designed to manage, organize, upload, approve, archive, and monitor faculty documents digitally for the Human Resource Office of Iloilo Science and Technology University - Miagao Campus.
</td>
</tr>

</table>

<hr class="my-4">

<h4 class="fw-bold" id="about">About System</h4>

<p>
This Documents Management System was developed to digitize and manage faculty document submission, approval, tracking, and reporting for the Human Resource Office of Iloilo Science and Technology University.
</p>

<table class="table">
<tr>
<td width="220"><strong>Capstone Project</strong></td>
<td>Documents Management System of ISAT U HR</td>
</tr>
<tr>
<td><strong>Developers</strong></td>
<td>John Carlo P. Gabadal, Michael A. Atilano Jr., Gian Alexis E. Ecle</td>
</tr>
<tr>
<td><strong>Course</strong></td>
<td>Bachelor of Science in Information Technology (BSIT)</td>
</tr>
<tr>
<td><strong>School</strong></td>
<td>Iloilo Science and Technology University</td>
</tr>
<tr>
<td><strong>Version</strong></td>
<td>Version 1.0</td>
</tr>
</table>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>