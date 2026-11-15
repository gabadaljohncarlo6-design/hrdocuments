<?php
/*
| "Change Password" section shown inside the Profile page of admin, HR and faculty.
| Expects $conn and $user_id. Handles its own form (cp_submit).
*/
$cp_msg = "";
if (isset($_POST['cp_submit'])) {
    $cp_uid = (int)$user_id;
    $cur = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $con = $_POST['confirm_password'] ?? '';
    $u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT password FROM users WHERE user_id='$cp_uid'"));

    if (!$u || !password_verify($cur, $u['password'])) {
        $cp_msg = "<div class='alert alert-danger py-2'>Current password is incorrect.</div>";
    } elseif (strlen($new) < 6) {
        $cp_msg = "<div class='alert alert-danger py-2'>New password must be at least 6 characters.</div>";
    } elseif ($new !== $con) {
        $cp_msg = "<div class='alert alert-danger py-2'>New passwords do not match.</div>";
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$hash' WHERE user_id='$cp_uid'");
        mysqli_query($conn, "INSERT INTO activity_logs (user_id, activity, module) VALUES ('$cp_uid', 'Changed own password', 'Authentication')");
        $cp_msg = "<div class='alert alert-success py-2'>Password changed successfully.</div>";
    }
}
?>
<hr class="my-4" id="change-password">
<h5 class="fw-bold mb-3"><i class="bi bi-key-fill"></i> Change Password</h5>
<?php echo $cp_msg; ?>
<form method="POST" autocomplete="off">
    <div class="row">
        <div class="col-12 mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" minlength="6" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" minlength="6" required>
        </div>
    </div>
    <button type="submit" name="cp_submit" class="btn btn-dark w-100">
        <i class="bi bi-shield-lock-fill"></i> Update Password
    </button>
</form>
<script src="../assets/password-toggle.js"></script>