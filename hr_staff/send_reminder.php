<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr')
{
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

include "../db.php";
include "../includes/mailer.php";
include "../includes/reminders.php";

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'No deadline specified']);
    exit();
}

$deadline_id = (int)$_GET['id'];

$deadline = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT sd.*, dc.category_name
FROM submission_deadlines sd
JOIN document_categories dc ON dc.category_id = sd.category_id
WHERE sd.deadline_id = '$deadline_id'
"));

if (!$deadline) {
    echo json_encode(['success' => false, 'message' => 'Deadline not found']);
    exit();
}

$count = send_weekly_reminder_for_deadline($conn, $deadline);

$hr_id = (int)$_SESSION['user_id'];
$catName = mysqli_real_escape_string($conn, $deadline['category_name']);
mysqli_query($conn, "
INSERT INTO activity_logs (user_id, activity, module)
VALUES ('$hr_id', 'Manually sent reminder for \"$catName\" to $count faculty', 'Deadlines')
");

echo json_encode(['success' => true, 'notified' => $count]);