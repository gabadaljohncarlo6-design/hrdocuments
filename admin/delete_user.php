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

$user_id = $_GET['id'];

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

// Check if user exists
$check = mysqli_query($conn,"
SELECT *
FROM users
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

// Deactivate user instead of deleting

mysqli_query($conn,"
UPDATE users
SET status='Inactive'
WHERE user_id='$user_id'
");

echo "
<script>
alert('User has been deactivated successfully.');
window.location='users.php';
</script>
";
?>