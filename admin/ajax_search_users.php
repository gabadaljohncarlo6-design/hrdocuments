<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    http_response_code(403);
    exit();
}

include "../db.php";

$departments = ['All','Computer Studies','HBM','BindTech','Education','Not Teaching','Others'];

$activeDept = isset($_GET['dept']) && in_array($_GET['dept'], $departments) ? $_GET['dept'] : 'All';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$where = "WHERE (employee_id LIKE '%$search%' OR first_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' OR role LIKE '%$search%')";

if ($activeDept !== 'All') {
    $where .= " AND department = '" . mysqli_real_escape_string($conn, $activeDept) . "'";
}

$query = mysqli_query($conn, "
SELECT *
FROM users
$where
ORDER BY role ASC, last_name ASC
");

include "partials/users_rows.php";