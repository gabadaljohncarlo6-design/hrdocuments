<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr')
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

if (!isset($_GET['id'])) {
    header("Location: find_faculty.php");
    exit();
}

$user_id = (int)$_GET['id'];

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'"));

if (!$user) {
    header("Location: find_faculty.php");
    exit();
}

$documents = mysqli_query($conn, "
SELECT d.*, dc.category_name
FROM documents d
LEFT JOIN document_categories dc ON d.category_id = dc.category_id
WHERE d.user_id = '$user_id'
ORDER BY d.submitted_at DESC
");

$total_docs = mysqli_num_rows($documents);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Faculty Profile</title>
<link rel="icon" href="../images/isatu_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#eef3fb;overflow-x:hidden;}
.sidebar{position:fixed;top:0;left:0;width:110px;height:100vh;background:linear-gradient(180deg,#0A2E73,#123C92);padding:16px 8px;overflow-y:auto;overflow-x:hidden;z-index:999;}
.sidebar img{width:44px;display:block;margin:auto;}
.sidebar h3{color:#fff;text-align:center;margin-top:8px;font-weight:700;font-size:12px;line-height:1.2;}
.sidebar p{color:#ddd;text-align:center;margin-bottom:18px;font-size:10px;}
.sidebar a{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;padding:10px 4px;margin-bottom:8px;text-decoration:none;color:#fff;border-radius:12px;transition:.3s;font-weight:500;font-size:10.5px;line-height:1.2;text-align:center;word-break:break-word;white-space:normal;}
.sidebar a i{font-size:18px;}
.sidebar a:hover{background:#F5B400;color:#000;}
.sidebar a.active{background:#F5B400;color:#000;}
.main{margin-left:110px;padding:30px;}
.topbar{background:#fff;padding:20px 30px;border-radius:18px;box-shadow:0 8px 20px rgba(0,0,0,.08);display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;}
.topbar h2{margin:0;font-size:26px;font-weight:700;color:#0A2E73;}
.profile-card,.documents-card{background:#fff;padding:25px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,.08);}
.avatar{width:90px;height:90px;border-radius:50%;background:#0A2E73;color:#fff;display:flex;align-items:center;justify-content:center;font-size:34px;font-weight:700;}
.profile-grid div{margin-bottom:16px;}
.profile-grid label{font-size:12px;color:#888;text-transform:uppercase;letter-spacing:.5px;}
.profile-grid p{font-weight:600;color:#222;margin:0;overflow-wrap:break-word;word-break:break-word;}
.table thead{background:#0A2E73;color:#fff;}
</style>
<link rel="stylesheet" href="../assets/ui.css">
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php" title="Go to Dashboard" style="padding:0;margin:0 auto 4px;background:none;display:block;width:fit-content;text-decoration:none;"><img src="../images/isatu_logo.png"></a>
    <h3>ISAT U HRMS</h3>
    <p>HR Staff Panel</p>

    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="deadlines.php"><i class="bi bi-calendar-event-fill"></i> Submission Deadlines</a>
    <a href="find_faculty.php" class="active"><i class="bi bi-people-fill"></i> Find Faculty</a>
<a href="repository.php"><i class="bi bi-folder-symlink-fill"></i> File Repository</a>
    <a href="reports.php"><i class="bi bi-bar-chart-fill"></i> Reports</a>
    <a href="profile.php"><i class="bi bi-person-circle"></i> My Profile</a>
    <a href="change_password.php"><i class="bi bi-key-fill"></i> Change Password</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">

<div class="topbar">
    <h2>Faculty Profile</h2>
    <a href="find_faculty.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row g-4 align-items-start">

    <div class="col-xl-4 col-lg-5">
        <div class="profile-card h-100">
            <div class="text-center mb-4">
                <?php if (!empty($user['profile_picture']) && file_exists('../uploads/profile_pictures/'.$user['profile_picture'])): ?>
                    <img src="../uploads/profile_pictures/<?php echo htmlspecialchars($user['profile_picture']); ?>"
                         class="mx-auto mb-3" style="width:90px;height:90px;border-radius:50%;object-fit:cover;display:block;">
                <?php else: ?>
                    <div class="avatar mx-auto mb-3">
                        <?php echo strtoupper(substr($user['first_name'],0,1)); ?>
                    </div>
                <?php endif; ?>
                <h4 class="fw-bold mb-1">
                    <?php echo htmlspecialchars($user['first_name'].' '.$user['middle_name'].' '.$user['last_name']); ?>
                </h4>
                <span class="badge bg-primary"><?php echo htmlspecialchars(ucfirst($user['role'])); ?></span>
            </div>
            <hr>
            <div class="profile-grid">
                <div><label>Employee ID</label><p><?php echo htmlspecialchars($user['employee_id']); ?></p></div>
                <div><label>Email</label><p><?php echo htmlspecialchars($user['email']); ?></p></div>
                <div><label>Department</label><p><?php echo htmlspecialchars($user['department']); ?></p></div>
                <div><label>Position</label><p><?php echo htmlspecialchars($user['position_title'] ?: '—'); ?></p></div>
                <div><label>Status</label><p><?php echo htmlspecialchars($user['status']); ?></p></div>
                <div><label>Registered</label><p><?php echo date("F d, Y", strtotime($user['created_at'])); ?></p></div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7">
        <div class="documents-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">All Documents</h5>
                <span class="badge bg-primary"><?php echo $total_docs; ?> Documents</span>
            </div>

            <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($total_docs > 0): while ($doc = mysqli_fetch_assoc($documents)):
                    $color = "secondary";
                    if ($doc['status']=="Approved") $color="success";
                    elseif ($doc['status']=="Pending") $color="warning";
                    elseif ($doc['status']=="Rejected") $color="danger";
                    elseif ($doc['status']=="Returned") $color="info";
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($doc['document_title']); ?></td>
                        <td><?php echo htmlspecialchars($doc['category_name']); ?></td>
                        <td><span class="badge bg-<?php echo $color; ?>"><?php echo htmlspecialchars($doc['status']); ?></span></td>
                        <td><?php echo date("F d, Y", strtotime($doc['submitted_at'])); ?></td>
                        <td>
                            <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="5" class="text-center py-5">No documents found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>