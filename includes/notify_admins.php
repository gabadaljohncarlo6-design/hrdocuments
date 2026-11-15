<?php
/**
 * notify_admins() — adds an in-system notification for every active admin.
 *
 * Usage: notify_admins($conn, "Message text", 'status_update');
 * Save this file as: includes/notify_admins.php
 */

if (!function_exists('notify_admins')) {
    function notify_admins($conn, $message, $type = 'general')
    {
        $admins = mysqli_query($conn, "SELECT user_id FROM users WHERE role = 'admin' AND status = 'active'");

        if (!$admins) {
            error_log("notify_admins: could not load admins: " . mysqli_error($conn));
            return false;
        }

        $stmt = mysqli_prepare($conn, "INSERT INTO notifications (user_id, message, type) VALUES (?, ?, ?)");

        if (!$stmt) {
            error_log("notify_admins: prepare failed: " . mysqli_error($conn));
            return false;
        }

        while ($admin = mysqli_fetch_assoc($admins)) {
            $adminId = (int) $admin['user_id'];
            mysqli_stmt_bind_param($stmt, "iss", $adminId, $message, $type);
            mysqli_stmt_execute($stmt);
        }

        mysqli_stmt_close($stmt);
        return true;
    }
}