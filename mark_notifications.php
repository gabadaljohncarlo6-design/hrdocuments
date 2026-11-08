<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false]);
    exit();
}

include 'db.php';

$user_id = (int)$_SESSION['user_id'];

if (isset($_GET['id'])) {
    $notification_id = (int)$_GET['id'];
    mysqli_query($conn, "
    UPDATE notifications
    SET is_read = 1
    WHERE notification_id = '$notification_id' AND user_id = '$user_id'
    ");
} else {
    // mark all as read
    mysqli_query($conn, "
    UPDATE notifications
    SET is_read = 1
    WHERE user_id = '$user_id' AND is_read = 0
    ");
}

echo json_encode(['success' => true]);