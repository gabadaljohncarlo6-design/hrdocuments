<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

if(!isset($_GET['id']))
{
    header("Location: users.php");
    exit();
}

$user_id = (int)$_GET['id'];

// Prevent admin from deleting their own account
if($user_id == $_SESSION['user_id'])
{
    echo "
    <script>
    alert('You cannot delete your own account.');
    window.location='users.php';
    </script>
    ";
    exit();
}

$check = mysqli_query($conn,"
SELECT * FROM users
WHERE user_id='$user_id'
");

if(mysqli_num_rows($check)==0)
{
    echo "
    <script>
    alert('User not found.');
    window.location='users.php';
    </script>
    ";
    exit();
}

$user = mysqli_fetch_assoc($check);

// Safety: only allow permanent deletion of accounts that are already Inactive
if($user['status'] !== 'Inactive')
{
    echo "
    <script>
    alert('This account must be Inactive before it can be permanently deleted. Deactivate it first.');
    window.location='users.php';
    </script>
    ";
    exit();
}

$fullName = $user['first_name'].' '.$user['last_name'];

// Delete their uploaded files from disk
$docs = mysqli_query($conn, "SELECT file_path FROM documents WHERE user_id='$user_id'");
while ($d = mysqli_fetch_assoc($docs)) {
    if (file_exists($d['file_path'])) {
        @unlink($d['file_path']);
    }
}

// Delete their document records, notifications, and any deadlines they created (if they were HR)
mysqli_query($conn, "DELETE FROM documents WHERE user_id='$user_id'");
mysqli_query($conn, "DELETE FROM notifications WHERE user_id='$user_id'");
mysqli_query($conn, "DELETE FROM submission_deadlines WHERE created_by='$user_id'");

// Finally delete the account itself
mysqli_query($conn, "DELETE FROM users WHERE user_id='$user_id'");

$admin_id = (int)$_SESSION['user_id'];
$safeName = mysqli_real_escape_string($conn, $fullName);
mysqli_query($conn, "
INSERT INTO activity_logs (user_id, activity, module)
VALUES ('$admin_id', 'Permanently deleted account: $safeName (was Employee ID: {$user['employee_id']})', 'User Management')
");

echo "
<script>
alert('Account permanently deleted. This cannot be undone.');
window.location='users.php';
</script>
";