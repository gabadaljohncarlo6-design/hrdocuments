<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}

include 'db.php';

$user_id = (int)$_SESSION['user_id'];

$unread = mysqli_fetch_row(mysqli_query($conn, "
SELECT COUNT(*) FROM notifications
WHERE user_id = '$user_id' AND is_read = 0
"))[0];

$recent = mysqli_query($conn, "
SELECT notification_id, message, type, is_read, created_at
FROM notifications
WHERE user_id = '$user_id'
ORDER BY created_at DESC
LIMIT 8
");

$items = [];
while ($row = mysqli_fetch_assoc($recent)) {
    $items[] = [
        'id' => (int)$row['notification_id'],
        'message' => $row['message'],
        'type' => $row['type'] ?? 'general',
        'is_read' => (bool)$row['is_read'],
        'time' => date("M j, g:i A", strtotime($row['created_at'])),
    ];
}

echo json_encode([
    'unread_count' => (int)$unread,
    'notifications' => $items,
]);