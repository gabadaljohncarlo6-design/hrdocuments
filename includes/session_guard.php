<?php
/*
| Logs out anyone whose account was deactivated by the admin, even if they
| are already logged in. Included at the end of db.php.
| Skips pages that have not started a session yet.
*/
if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION['user_id']) && isset($conn) && $conn) {
    $sg_id = (int)$_SESSION['user_id'];
    $sg_res = mysqli_query($conn, "SELECT status FROM users WHERE user_id = '$sg_id' LIMIT 1");
    $sg_row = $sg_res ? mysqli_fetch_assoc($sg_res) : null;

    if (!$sg_row || strtolower(trim($sg_row['status'] ?? 'active')) === 'inactive') {
        $sg_dir = basename(dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $sg_login = in_array($sg_dir, ['admin', 'hr_staff', 'faculty'], true) ? '../login.php' : 'login.php';
        $_SESSION = [];
        session_destroy();
        header("Location: {$sg_login}?inactive=1");
        exit();
    }
}