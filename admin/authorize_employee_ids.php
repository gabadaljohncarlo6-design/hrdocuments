<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$message = "";

if (isset($_POST['add'])) {

    $employee_id = trim($_POST['employee_id']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $admin_id = (int)$_SESSION['user_id'];

    if (empty($employee_id)) {
        $message = "<div class='alert alert-danger'>Employee ID cannot be empty.</div>";
    } else {
        $safeId = mysqli_real_escape_string($conn, $employee_id);

        $exists = mysqli_query($conn, "SELECT id FROM authorized_employee_ids WHERE employee_id = '$safeId'");

        if (mysqli_num_rows($exists) > 0) {
            $message = "<div class='alert alert-danger'>That Employee ID is already authorized.</div>";
        } else {
            mysqli_query($conn, "
            INSERT INTO authorized_employee_ids (employee_id, department, added_by)
            VALUES ('$safeId', '$department', '$admin_id')
            ");

            mysqli_query($conn, "
            INSERT INTO activity_logs (user_id, activity, module)
            VALUES ('$admin_id', 'Authorized Employee ID for registration: $safeId', 'User Management')
            ");

            $message = "<div class='alert alert-success'>Employee ID <strong>" . htmlspecialchars($employee_id) . "</strong> authorized. That person can now register.</div>";
        }
    }
}

if (isset($_GET['delete'])) {

    $id = (int)$_GET['delete'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM authorized_employee_ids WHERE id='$id'"));

    if ($row && (int)$row['is_claimed'] === 0) {
        mysqli_query($conn, "DELETE FROM authorized_employee_ids WHERE id='$id'");

        $admin_id = (int)$_SESSION['user_id'];
        $safeId = mysqli_real_escape_string($conn, $row['employee_id']);
        mysqli_query($conn, "
        INSERT INTO activity_logs (user_id, activity, module)
        VALUES ('$admin_id', 'Removed authorized Employee ID: $safeId', 'User Management')
        ");

        $message = "<div class='alert alert-success'>Employee ID removed from the authorized list.</div>";
    } else {
        $message = "<div class='alert alert-danger'>Cannot remove an Employee ID that has already been claimed (used to register).</div>";
    }
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$list = mysqli_query($conn, "
SELECT a.*, u.first_name, u.last_name
FROM authorized_employee_ids a
LEFT JOIN users u ON u.employee_id = a.employee_id
WHERE a.employee_id LIKE '%$search%'
ORDER BY a.added_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Authorize Employee IDs</title>
<link rel="icon" href="../images/isatu_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#eef3fb;overflow-x:hidden;}
.sidebar{position:fixed;top:0;left:0;width:110px;height:100vh;background:linear-gradient(180deg,#0A2E73,#123c92);padding:16px 8px;overflow-y:auto;overflow-x:hidden;z-index:999;}
.sidebar img{width:44px;display:block;margin:auto;}
.sidebar h3{color:#fff;text-align:center;margin-top:8px;font-weight:700;font-size:12px;line-height:1.2;}
.sidebar p{color:#ddd;text-align:center;margin-bottom:18px;font-size:10px;}
.sidebar a{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;padding:10px 4px;margin-bottom:8px;text-decoration:none;color:#fff;border-radius:12px;transition:.3s;font-weight:500;font-size:10.5px;line-height:1.2;text-align:center;word-break:break-word;white-space:normal;}
.sidebar a i{font-size:18px;}
.sidebar a:hover{background:#F5B400;color:#000;}
.sidebar a.active{background:#F5B400;color:#000;}
.main{margin-left:110px;padding:30px;}
.topbar{background:#fff;padding:20px 30px;border-radius:18px;box-shadow:0 8px 20px rgba(0,0,0,.08);margin-bottom:25px;}
.topbar h2{margin:0;font-size:26px;font-weight:700;color:#0A2E73;}
.card-box{background:#fff;padding:25px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,.08);margin-bottom:25px;}
.table thead{background:#0A2E73;color:#fff;}
.btn-save{background:#0A2E73;color:#fff;}
.btn-save:hover{background:#F5B400;color:#000;}
</style>
<link rel="stylesheet" href="../assets/ui.css">
</head>
<body>

<div class="sidebar">
<img src="../images/isatu_logo.png">
<h3>ISAT U HRMS</h3>
<p>Administrator Panel</p>
<a href="dashboard.php"><i class="bi bi-speedometer2"></i>Dashboard</a>
<a href="users.php"><i class="bi bi-people-fill"></i>Manage Users</a>
<a href="repository.php"><i class="bi bi-folder-symlink-fill"></i>File Repository</a>
<a href="authorize_employee_ids.php" class="active"><i class="bi bi-shield-check"></i>Authorize IDs</a>
<a href="activity_logs.php"><i class="bi bi-clock-history"></i>Activity Logs</a>
<a href="reports.php"><i class="bi bi-bar-chart-fill"></i>Reports</a>
<a href="settings.php"><i class="bi bi-gear-fill"></i>Settings</a>
<a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"><i class="bi bi-box-arrow-right"></i>Logout</a>
</div>

<div class="main">

<div class="topbar">
<h2><i class="bi bi-shield-check"></i> Authorize Employee IDs</h2>
<p class="text-muted mb-0">Only Employee IDs added here can complete registration on the system.</p>
</div>

<?php echo $message; ?>

<div class="card-box">
<h5 class="fw-bold mb-3"><i class="bi bi-plus-circle"></i> Authorize a New Employee ID</h5>

<form method="POST" class="row g-3">

<div class="col-md-5">
<label class="form-label">Employee ID</label>
<input type="text" name="employee_id" class="form-control" placeholder="e.g. 2023-4111-M" required>
</div>

<div class="col-md-5">
<label class="form-label">Department (optional)</label>
<select name="department" class="form-select">
<option value="" selected>Not specified</option>
<option value="Computer Studies">Computer Studies</option>
<option value="HBM">HBM</option>
<option value="BindTech">BindTech</option>
<option value="Education">Education</option>
<option value="Not Teaching">Not Teaching</option>
<option value="Others">Others</option>
</select>
</div>

<div class="col-md-2 d-flex align-items-end">
<button type="submit" name="add" class="btn btn-save w-100">
<i class="bi bi-shield-plus"></i> Authorize
</button>
</div>

</form>
</div>

<div class="card-box">

<div class="d-flex justify-content-between align-items-center mb-3">
<h5 class="fw-bold mb-0"><i class="bi bi-list-check"></i> Authorized Employee IDs</h5>

<form method="GET" class="d-flex" style="max-width:300px;">
<input type="text" name="search" class="form-control" placeholder="Search Employee ID" value="<?php echo htmlspecialchars($search); ?>">
</form>
</div>

<div class="table-responsive">
<table class="table table-hover align-middle">
<thead>
<tr>
<th>Employee ID</th>
<th>Department</th>
<th>Added</th>
<th>Status</th>
<th width="120">Action</th>
</tr>
</thead>
<tbody>
<?php if (mysqli_num_rows($list) === 0): ?>
<tr><td colspan="5" class="text-center text-muted py-4">No authorized Employee IDs yet.</td></tr>
<?php else: while ($row = mysqli_fetch_assoc($list)): ?>
<tr>
<td><?php echo htmlspecialchars($row['employee_id']); ?></td>
<td><?php echo htmlspecialchars($row['department'] ?: '—'); ?></td>
<td><?php echo date("M j, Y", strtotime($row['added_at'])); ?></td>
<td>
<?php if ($row['is_claimed']): ?>
<span class="badge bg-success">Claimed<?php echo $row['first_name'] ? ' — '.htmlspecialchars($row['first_name'].' '.$row['last_name']) : ''; ?></span>
<?php else: ?>
<span class="badge bg-warning text-dark">Not Registered Yet</span>
<?php endif; ?>
</td>
<td>
<?php if (!$row['is_claimed']): ?>
<a href="authorize_employee_ids.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remove this authorized Employee ID?')">
<i class="bi bi-trash-fill"></i>
</a>
<?php else: ?>
<span class="text-muted">—</span>
<?php endif; ?>
</td>
</tr>
<?php endwhile; endif; ?>
</tbody>
</table>
</div>

</div>

</div>

</body>
</html>