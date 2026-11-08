<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

if (!isset($_GET['id'])) {
    header("Location: documents.php");
    exit();
}

$document_id = (int)$_GET['id'];
$action = isset($_GET['restore']) ? 0 : 1; // restore=1 in URL means un-archive

mysqli_query($conn, "
UPDATE documents
SET is_archived = '$action'
WHERE document_id = '$document_id'
");

$admin_id = (int)$_SESSION['user_id'];
$verb = $action ? 'Archived' : 'Restored';
mysqli_query($conn, "
INSERT INTO activity_logs (user_id, activity, module)
VALUES ('$admin_id', '$verb document (ID: $document_id)', 'Documents')
");

header("Location: " . ($action ? "documents.php" : "archive_documents.php"));
exit();