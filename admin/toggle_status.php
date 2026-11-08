<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['user_id']))
{
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

include "../db.php";

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'No user specified']);
    exit();
}

$id = (int)$_GET['id'];

$result = mysqli_query($conn, "SELECT status, first_name, last_name FROM users WHERE user_id = '$id'");

if (mysqli_num_rows($result) === 0) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit();
}

$user = mysqli_fetch_assoc($result);
$newStatus = ($user['status'] === 'Active') ? 'Inactive' : 'Active';

mysqli_query($conn, "UPDATE users SET status = '$newStatus' WHERE user_id = '$id'");

$actorId = (int)$_SESSION['user_id'];
$fullname = mysqli_real_escape_string($conn, $user['first_name'].' '.$user['last_name']);

mysqli_query($conn, "
INSERT INTO activity_logs (user_id, activity, module)
VALUES ('$actorId', 'Set $fullname to $newStatus', 'User Management')
");

echo json_encode(['success' => true, 'new_status' => $newStatus]);