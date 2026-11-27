<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr')
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$user_id = (int)$_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Documents</title>
<link rel="icon" href="../images/isatu_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
*{font-family:'Poppins',sans-serif;}
body{background:#eef3fb;}
.sidebar{position:fixed;top:0;left:0;width:110px;height:100vh;background:linear-gradient(180deg,#5b92e5,#2a63bd);padding:16px 8px;overflow-y:auto;overflow-x:hidden;z-index:999;}
.sidebar img{width:44px;display:block;margin:auto;}
.sidebar h3{color:#fff;text-align:center;margin-top:8px;font-weight:700;font-size:12px;line-height:1.2;}
.sidebar p{color:#ddd;text-align:center;margin-bottom:18px;font-size:10px;}
.sidebar a{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;padding:10px 4px;margin-bottom:8px;text-decoration:none;color:#fff;border-radius:12px;transition:.3s;font-weight:500;font-size:10.5px;line-height:1.2;text-align:center;}
.sidebar a i{font-size:18px;}
.sidebar a:hover,.sidebar a.active{background:#F5B400;color:#000;}
.main{margin-left:110px;padding:20px 24px;}
.topbar{background:#fff;padding:12px 20px;border-radius:12px;box-shadow:0 4px 14px rgba(10,46,115,.08);margin-bottom:16px;}
.topbar h2{margin:0;font-weight:700;color:#0A2E73;}
.status-select{padding-right:2rem !important;min-width:125px;}
.box{background:#fff;border-radius:12px;padding:18px;box-shadow:0 4px 14px rgba(10,46,115,.08);}
</style>
<link rel="stylesheet" href="../assets/ui.css">
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php" title="Go to Dashboard" style="padding:0;margin:0 auto 4px;background:none;display:block;width:fit-content;text-decoration:none;"><img src="../images/isatu_logo.png"></a>
    <h3>ISAT U HRMS</h3>
    <p>HR Staff Panel</p>
    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="documents.php" class="active"><i class="bi bi-folder2-open"></i> Documents</a>
    <a href="deadlines.php"><i class="bi bi-calendar-event-fill"></i> Submission Deadlines</a>
    <a href="find_faculty.php"><i class="bi bi-people-fill"></i> Find Faculty</a>
    <a href="repository.php"><i class="bi bi-folder-symlink-fill"></i> File Repository</a>
    <a href="templates.php"><i class="bi bi-file-earmark-arrow-down-fill"></i> Template</a>
    <a href="reports.php"><i class="bi bi-bar-chart-fill"></i> Reports</a>
    <a href="profile.php"><i class="bi bi-person-circle"></i> My Profile</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">

<div class="topbar">
    <h2>Documents</h2>
    <p class="text-muted mb-0">View and review all documents submitted by the faculty.</p>
</div>

<?php
$search   = trim($_GET['search'] ?? '');
$category = (int)($_GET['category'] ?? 0);
$fstatus  = $_GET['status'] ?? '';
$fdate    = $_GET['date'] ?? '';

$where = "WHERE (documents.is_archived IS NULL OR documents.is_archived = 0)";
if ($search !== '') {
    $sq = mysqli_real_escape_string($conn, $search);
    $where .= " AND (users.first_name LIKE '%$sq%' OR users.last_name LIKE '%$sq%' OR documents.document_title LIKE '%$sq%')";
}
if ($category) { $where .= " AND documents.category_id=$category"; }
if (in_array($fstatus, ['Pending','Approved','Rejected','Returned'], true)) {
    $where .= " AND documents.status='" . mysqli_real_escape_string($conn, $fstatus) . "'";
}

$dateSql = [
    'today' => "DATE(documents.submitted_at) = CURDATE()",
    'week'  => "YEARWEEK(documents.submitted_at, 1) = YEARWEEK(CURDATE(), 1)",
    'month' => "YEAR(documents.submitted_at) = YEAR(CURDATE()) AND MONTH(documents.submitted_at) = MONTH(CURDATE())",
    'year'  => "YEAR(documents.submitted_at) = YEAR(CURDATE())",
];
if (isset($dateSql[$fdate])) { $where .= " AND (" . $dateSql[$fdate] . ")"; }

$cats = mysqli_query($conn, "SELECT * FROM document_categories ORDER BY category_name ASC");
$query = mysqli_query($conn, "
    SELECT documents.*, users.first_name, users.last_name, document_categories.category_name
    FROM documents
    LEFT JOIN users ON users.user_id = documents.user_id
    LEFT JOIN document_categories ON document_categories.category_id = documents.category_id
    $where
    ORDER BY documents.submitted_at DESC
");
?>

<div class="box mb-3">
    <form method="GET" class="row g-2">
        <div class="col-lg-3">
            <input type="text" name="search" class="form-control" placeholder="Search faculty or document..." value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <div class="col-lg-2">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                <?php while ($cat = mysqli_fetch_assoc($cats)): ?>
                <option value="<?php echo $cat['category_id']; ?>" <?php if ($category == $cat['category_id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['category_name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-lg-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <?php foreach (['Pending','Approved','Rejected','Returned'] as $o): ?>
                <option value="<?php echo $o; ?>" <?php if ($fstatus === $o) echo 'selected'; ?>><?php echo $o; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-2">
            <select name="date" class="form-select">
                <option value="">All Dates</option>
                <?php foreach (['today'=>'Today','week'=>'This Week','month'=>'This Month','year'=>'This Year'] as $k=>$lbl): ?>
                <option value="<?php echo $k; ?>" <?php if ($fdate === $k) echo 'selected'; ?>><?php echo $lbl; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-1 d-grid">
            <button class="btn btn-primary"><i class="bi bi-search"></i></button>
        </div>
    </form>
</div>

<div class="box">
    <h5 class="fw-bold mb-3"><i class="bi bi-folder2-open"></i> Documents</h5>
    <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Faculty</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Submitted Date</th>
                <th>Feedback</th>
                <th width="120">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($query && mysqli_num_rows($query) > 0): while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></strong></td>
                <td><?php echo htmlspecialchars($row['document_title']); ?></td>
                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                <td>
                    <form id="f<?php echo (int)$row['document_id']; ?>" method="POST" action="dashboard.php" style="display:none">
                        <input type="hidden" name="document_id" value="<?php echo (int)$row['document_id']; ?>">
                        <input type="hidden" name="update" value="1">
                        <input type="hidden" name="return_to" value="documents.php">
                    </form>
                    <select name="status" form="f<?php echo (int)$row['document_id']; ?>" class="form-select form-select-sm status-select" onchange="this.form.submit()">
                        <?php foreach (["Pending","Approved","Rejected","Returned"] as $opt): ?>
                        <option value="<?php echo $opt; ?>" <?php if ($row['status'] == $opt) echo 'selected'; ?>><?php echo $opt; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td style="min-width:200px;">
                    <input type="text" name="remarks" form="f<?php echo (int)$row['document_id']; ?>" class="form-control form-control-sm" placeholder="Type remarks, press Enter" value="<?php echo htmlspecialchars($row['hr_remarks'] ?? ''); ?>" onchange="this.form.submit()">
                </td>
                <td><?php echo date("M d, Y", strtotime($row['submitted_at'])); ?></td>
                <td>
                    <a href="send_file.php?id=<?php echo (int)$row['document_id']; ?>" class="btn btn-sm btn-warning" title="Send corrected file to faculty"><i class="bi bi-send-fill"></i> Send File</a>
                </td>
                <td>
                    <a href="<?php echo htmlspecialchars($row['file_path']); ?>" target="_blank" class="btn btn-sm btn-primary" title="View file"><i class="bi bi-eye-fill"></i></a>
                    <a href="faculty_profile.php?id=<?php echo (int)$row['user_id']; ?>" class="btn btn-sm btn-info text-white" title="Faculty profile"><i class="bi bi-person-fill"></i></a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="8" class="text-center text-muted py-4">No documents found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

</div>
</body>
</html>