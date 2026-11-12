<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr')
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$totalDocuments=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*) FROM documents
"))[0];

$pending=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*) FROM documents
WHERE status='Pending'
"))[0];

$approved=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*) FROM documents
WHERE status='Approved'
"))[0];

$rejected=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*) FROM documents
WHERE status='Rejected'
"))[0];

$returned=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*) FROM documents
WHERE status='Returned'
"))[0];

$byCategory = mysqli_query($conn, "
SELECT dc.category_name, COUNT(d.document_id) AS total
FROM documents d
JOIN document_categories dc ON dc.category_id = d.category_id
GROUP BY dc.category_id
ORDER BY total DESC
");

$categoryLabels = [];
$categoryData = [];
while ($row = mysqli_fetch_assoc($byCategory)) {
    $categoryLabels[] = $row['category_name'];
    $categoryData[] = (int)$row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HR Reports</title>
<link rel="icon" href="../images/isatu_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
.topbar{background:#fff;padding:20px 30px;border-radius:18px;box-shadow:0 8px 20px rgba(0,0,0,.08);margin-bottom:25px;}
.topbar h2{margin:0;font-size:28px;font-weight:700;color:#0A2E73;}
.stat-card{background:#fff;border-radius:18px;padding:22px;box-shadow:0 8px 20px rgba(0,0,0,.08);text-align:center;}
.stat-card h6{color:#777;font-size:14px;margin-bottom:8px;font-weight:500;}
.stat-card h2{font-weight:700;margin:0;}
.text-blue{ color:#0A2E73; }
.text-green{ color:#28a745; }
.text-red{ color:#dc3545; }
.text-yellow{ color:#F5B400; }
.chart-card{background:#fff;border-radius:18px;padding:22px;box-shadow:0 8px 20px rgba(0,0,0,.08);margin-top:20px;}
.chart-card h5{font-weight:700;color:#0A2E73;margin-bottom:15px;}
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
    <a href="find_faculty.php"><i class="bi bi-people-fill"></i> Find Faculty</a>
<a href="repository.php"><i class="bi bi-folder-symlink-fill"></i> File Repository</a>
    <a href="reports.php" class="active"><i class="bi bi-bar-chart-fill"></i> Reports</a>
    <a href="profile.php"><i class="bi bi-person-circle"></i> My Profile</a>
    <a href="change_password.php"><i class="bi bi-key-fill"></i> Change Password</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">

<div class="topbar">
<h2><i class="bi bi-bar-chart-fill"></i> HR Reports</h2>
</div>

<div class="row g-4">

<div class="col-md-3">
<div class="stat-card">
<h6>Total Documents</h6>
<h2 class="text-blue"><?php echo $totalDocuments; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="stat-card">
<h6>Approved</h6>
<h2 class="text-green"><?php echo $approved; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="stat-card">
<h6>Rejected</h6>
<h2 class="text-red"><?php echo $rejected; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="stat-card">
<h6>Returned</h6>
<h2 class="text-yellow"><?php echo $returned; ?></h2>
</div>
</div>

</div>

<div class="chart-card">
<h5><i class="bi bi-bar-chart-line-fill"></i> Documents Submitted by Type</h5>
<canvas id="categoryChart" height="90"></canvas>
</div>

</div>

<script>
new Chart(document.getElementById('categoryChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($categoryLabels); ?>,
        datasets: [{
            label: 'Documents',
            data: <?php echo json_encode($categoryData); ?>,
            backgroundColor: '#0A2E73'
        }]
    },
    options: {
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
        plugins: { legend: { display: false } }
    }
});
</script>

</body>
</html>