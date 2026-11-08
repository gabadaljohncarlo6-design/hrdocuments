<?php

session_start();

if (isset($_SESSION['user_id'])) {
    include 'db.php';
    $user_id = (int)$_SESSION['user_id'];
    $ip = mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR'] ?? 'unknown');
    mysqli_query($conn, "
    INSERT INTO activity_logs (user_id, activity, module, ip_address)
    VALUES ('$user_id', 'Logged out', 'Authentication', '$ip')
    ");
}

session_unset();

session_destroy();

header("Location: login.php");

exit();

?>