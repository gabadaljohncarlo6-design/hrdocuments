<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr')
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

if (!isset($_GET['id'])) {
    header("Location: deadlines.php");
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
    header("Location: deadlines.php");
    exit();
}

$category_id = (int)$deadline['category_id'];

$faculty = mysqli_query($conn, "
SELECT u.user_id, u.employee_id, u.first_name, u.middle_name, u.last_name, u.department,
    (
        SELECT d.submitted_at FROM documents d
        WHERE d.user_id = u.user_id AND d.category_id = '$category_id' AND d.submitted_at >= '{$deadline['created_at']}'
        ORDER BY d.submitted_at DESC LIMIT 1
    ) AS submitted_at
FROM users u
WHERE u.role = 'faculty' AND u.status = 'Active'
ORDER BY u.department ASC, u.last_name ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deadline Submissions</title>
<link rel="icon" href="../images/isatu_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#eef3fb;overflow-x:hidden;}
.sidebar{position:fixed;left:0;top:0;width:210px;height:100vh;background:linear-gradient(180deg,#0A2E73,#123C92);padding:25px;overflow-y:auto;}
.sidebar img{width:90px;display:block;margin:auto;}
.sidebar h3{color:#fff;text-align:center;margin-top:15px;font-weight:700;}
.sidebar p{color:#ddd;text-align:center;margin-bottom:35px;font-size:14px;}
.sidebar a{display:flex;align-items:center;gap:14px;padding:14px 18px;margin-bottom:10px;text-decoration:none;color:#fff;border-radius:12px;transition:.3s;font-weight:500;}
.sidebar a:hover{background:#F5B400;color:#000;}
.sidebar a.active{background:#F5B400;color:#000;}
.main{margin-left:210px;padding:30px;}
.topbar{background:#fff;padding:20px 30px;border-radius:18px;box-shadow:0 8px 20px rgba(0,0,0,.08);display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;}
.topbar h2{margin:0;font-size:26px;font-weight:700;color:#0A2E73;}
.card-box{background:#fff;padding:25px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,.08);}
.table thead{background:#0A2E73;color:#fff;}
.dept-tabs{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:20px;}
.dept-tabs button{padding:8px 16px;border-radius:999px;background:#eef3fb;color:#0A2E73;border:1.5px solid #dce4f5;font-size:14px;font-weight:500;}
.dept-tabs button.active{background:#0A2E73;color:#fff;border-color:#0A2E73;}
</style>
<link rel="stylesheet" href="../assets/ui.css">
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php" title="Go to Dashboard" style="padding:0;margin:0 auto 4px;background:none;display:block;width:fit-content;text-decoration:none;"><img src="../images/isatu_logo.png"></a>
    <h3>ISAT U HRMS</h3>
    <p>HR Staff Panel</p>

    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="deadlines.php" class="active"><i class="bi bi-calendar-event-fill"></i> Submission Deadlines</a>
    <a href="find_faculty.php"><i class="bi bi-people-fill"></i> Find Faculty</a>
<a href="repository.php"><i class="bi bi-folder-symlink-fill"></i> File Repository</a>
    <a href="reports.php"><i class="bi bi-bar-chart-fill"></i> Reports</a>
    <a href="profile.php"><i class="bi bi-person-circle"></i> My Profile</a>
    <a href="change_password.php"><i class="bi bi-key-fill"></i> Change Password</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">

<div class="topbar">
    <div>
        <h2><?php echo htmlspecialchars($deadline['category_name']); ?> — Submission Status</h2>
        <p class="text-muted mb-0">
            Deadline: <?php echo date("M j, Y", strtotime($deadline['deadline_date'])); ?>
            at <?php echo date("g:i A", strtotime($deadline['deadline_time'])); ?>
        </p>
    </div>
    <a href="deadlines.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-box">

<div class="dept-tabs" id="deptTabs">
    <button type="button" class="active" data-dept="All">All</button>
    <button type="button" data-dept="Computer Studies">Computer Studies</button>
    <button type="button" data-dept="HBM">HBM</button>
    <button type="button" data-dept="BindTech">BindTech</button>
    <button type="button" data-dept="Education">Education</button>
    <button type="button" data-dept="Not Teaching">Not Teaching</button>
    <button type="button" data-dept="Others">Others</button>
</div>

<div class="table-responsive">
<table class="table table-hover align-middle" id="facultyTable">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Status</th>
            <th>Submitted On</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($f = mysqli_fetch_assoc($faculty)): ?>
        <tr data-dept="<?php echo htmlspecialchars($f['department']); ?>">
            <td><?php echo htmlspecialchars($f['employee_id']); ?></td>
            <td><?php echo htmlspecialchars($f['first_name'].' '.$f['last_name']); ?></td>
            <td><?php echo htmlspecialchars($f['department']); ?></td>
            <td>
                <?php if ($f['submitted_at']): ?>
                    <span class="badge bg-success">Submitted</span>
                <?php else: ?>
                    <span class="badge bg-danger">Not Submitted</span>
                <?php endif; ?>
            </td>
            <td><?php echo $f['submitted_at'] ? date("M j, Y g:i A", strtotime($f['submitted_at'])) : '—'; ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('#deptTabs button').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('#deptTabs button').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const dept = this.dataset.dept;

        document.querySelectorAll('#facultyTable tbody tr').forEach(row => {
            row.style.display = (dept === 'All' || row.dataset.dept === dept) ? '' : 'none';
        });
    });
});
</script>
</body>
</html>