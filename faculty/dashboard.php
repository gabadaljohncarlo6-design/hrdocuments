<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$user_id = $_SESSION['user_id'];

mysqli_query($conn,"
UPDATE notifications
SET is_read='1'
WHERE user_id='$user_id'
");

$total=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE user_id='$user_id'
"))[0];

$pending=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE user_id='$user_id'
AND status='Pending'
"))[0];

$approved=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE user_id='$user_id'
AND status='Approved'
"))[0];

$rejected=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE user_id='$user_id'
AND status='Rejected'
"))[0];

$returned=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE user_id='$user_id'
AND status='Returned'
"))[0];

date_default_timezone_set("Asia/Manila");

$hour=date("G");

if($hour>=5 && $hour<12)
{
    $greeting="Good Morning";
}
elseif($hour>=12 && $hour<18)
{
    $greeting="Good Afternoon";
}
else
{
    $greeting="Good Evening";
}

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Faculty Dashboard</title>

<link rel="icon" href="../images/isatu_logo.png">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#eef3fb;
overflow-x:hidden;
}

.sidebar{
position:fixed;
left:0;
top:0;
width:210px;
height:100vh;
background:linear-gradient(180deg,#5b92e5,#2a63bd);
padding:25px;
overflow:auto;
}

.sidebar img{
width:90px;
display:block;
margin:auto;
}

.sidebar h3{
color:#fff;
text-align:center;
margin-top:15px;
font-weight:700;
}

.sidebar p{
color:#ddd;
text-align:center;
margin-bottom:35px;
}

.sidebar a{
display:flex;
align-items:center;
gap:14px;
padding:14px 18px;
margin-bottom:12px;
text-decoration:none;
color:#fff;
border-radius:12px;
transition:.3s;
font-weight:500;
}

.sidebar a:hover{
background:#F5B400;
color:#000;
}

.main{
margin-left:210px;
padding:30px;
}

.topbar{
background:#fff;
padding:20px 30px;
border-radius:18px;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 8px 20px rgba(0,0,0,.08);
margin-bottom:25px;
}

.topbar h2{
margin:0;
font-weight:700;
color:#0A2E73;
}

.topbar p{
margin:0;
color:#666;
}

.stats{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
margin-bottom:25px;
}

.stat-card{
background:#fff;
padding:25px;
border-radius:18px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.stat-card h5{
color:#666;
margin-bottom:10px;
}

.stat-card h2{
color:#0A2E73;
font-weight:700;
}

.stat-card h2.text-blue{ color:#0A2E73; }
.stat-card h2.text-green{ color:#28a745; }
.stat-card h2.text-red{ color:#dc3545; }
.stat-card h2.text-yellow{ color:#F5B400; }

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="sidebar">

<img src="../images/isatu_logo.png">

<h3>ISAT U HRMS</h3>

<p>Faculty Portal</p>

<a href="dashboard.php">
<i class="bi bi-speedometer2"></i>
Dashboard
</a>

<a href="upload.php">
<i class="bi bi-cloud-upload-fill"></i>
Upload Document
</a>

<a href="my_documents.php">
<i class="bi bi-folder-fill"></i>
My Documents
</a>

<a href="notifications.php">
<i class="bi bi-bell-fill"></i>
Notifications
</a>

<a href="profile.php">
<i class="bi bi-person-circle"></i>
My Profile
</a>

<a href="change_password.php">
<i class="bi bi-key-fill"></i>
Change Password
</a>

<a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</div>

<div class="main">

<div class="topbar">

<div>

<h2><?php echo $greeting; ?>, <?php echo $_SESSION['fullname']; ?></h2>

<p><?php echo date("l, F d, Y"); ?></p>

</div>

<div class="d-flex align-items-center gap-3">

<?php

$notifCount=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM notifications
WHERE user_id='$user_id'
AND is_read='0'
"))[0];

?>

<div class="dropdown">

<button
class="btn btn-light position-relative"
data-bs-toggle="dropdown">

<i class="bi bi-bell-fill fs-4"></i>

<?php if($notifCount>0){ ?>

<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

<?php echo $notifCount; ?>

</span>

<?php } ?>

</button>

<ul class="dropdown-menu dropdown-menu-end" style="width:350px;max-height:350px;overflow:auto;">

<?php

$notif=mysqli_query($conn,"
SELECT *
FROM notifications
WHERE user_id='$user_id'
ORDER BY notification_id DESC
LIMIT 10
");

if(mysqli_num_rows($notif)>0)
{

while($n=mysqli_fetch_assoc($notif))
{

?>

<li>

<div class="dropdown-item">

<?php echo htmlspecialchars($n['message']); ?>

<br>

<small class="text-muted">

<?php echo date("M d, Y h:i A",strtotime($n['created_at'])); ?>

</small>

</div>

</li>

<li><hr class="dropdown-divider"></li>

<?php

}

}
else
{

?>

<li>

<div class="dropdown-item text-center">

No notifications

</div>

</li>

<?php

}

?>

</ul>

</div>

<img src="../images/isatu_logo.png" width="55">

</div>

</div>
<div class="stats">

<div class="stat-card">

<h5>Total Documents</h5>

<h2 class="text-blue"><?php echo $total; ?></h2>

</div>

<div class="stat-card">

<h5>Approved</h5>

<h2 class="text-green"><?php echo $approved; ?></h2>

</div>

<div class="stat-card">

<h5>Rejected</h5>

<h2 class="text-red"><?php echo $rejected; ?></h2>

</div>

<div class="stat-card">

<h5>Returned</h5>

<h2 class="text-yellow"><?php echo $returned; ?></h2>

</div>

</div>

<div class="card shadow border-0 mb-4">

<div class="card-header bg-warning text-dark">
<h5 class="mb-0"><i class="bi bi-megaphone-fill"></i> Announcements</h5>
</div>

<div class="card-body" style="max-height:220px;overflow-y:auto;">

<?php
$announcements = mysqli_query($conn, "SELECT * FROM announcements ORDER BY created_at DESC LIMIT 5");

if (mysqli_num_rows($announcements) === 0) {
    echo "<p class='text-muted mb-0'>No announcements yet.</p>";
} else {
    while ($a = mysqli_fetch_assoc($announcements)) {
        echo "<div class='mb-3 pb-2 border-bottom'>
            <strong>" . htmlspecialchars($a['title']) . "</strong>
            <p class='mb-1' style='font-size:14px;'>" . nl2br(htmlspecialchars($a['message'])) . "</p>
            <small class='text-muted'>" . date("F d, Y g:i A", strtotime($a['created_at'])) . "</small>
        </div>";
    }
}
?>

</div>

</div>

<div class="card shadow border-0">

<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

<h5 class="mb-0">

My Documents

</h5>

<input
type="text"
id="searchInput"
class="form-control w-25"
placeholder="Search Document">

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle" id="documentsTable">

<thead>

<tr>

<th>ID</th>

<th>Document</th>

<th>Category</th>

<th>Status</th>

<th>Date Submitted</th>

<th>Remarks</th>

</tr>

</thead>

<tbody>

<?php

$query=mysqli_query($conn,"
SELECT
documents.*,
document_categories.category_name
FROM documents
LEFT JOIN document_categories
ON documents.category_id=document_categories.category_id
WHERE documents.user_id='$user_id'
ORDER BY document_id DESC
");

while($row=mysqli_fetch_assoc($query))
{

?>

<tr>

<td><?php echo $row['document_id']; ?></td>

<td><?php echo htmlspecialchars($row['document_title']); ?></td>

<td><?php echo htmlspecialchars($row['category_name']); ?></td>

<td>

<?php

$status=$row['status'];

if($status=="Approved")
{
    echo "<span class='badge bg-success'>Approved</span>";
}
elseif($status=="Pending")
{
    echo "<span class='badge bg-warning text-dark'>Pending</span>";
}
elseif($status=="Returned")
{
    echo "<span class='badge bg-info text-dark'>Returned</span>";
}
else
{
    echo "<span class='badge bg-danger'>Rejected</span>";
}

?>

</td>

<td><?php echo date("F d, Y",strtotime($row['submitted_at'])); ?></td>

<td><?php echo htmlspecialchars($row['hr_remarks']); ?></td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>
<script>

document.getElementById("searchInput").addEventListener("keyup",function(){

let filter=this.value.toLowerCase();

let rows=document.querySelectorAll("#documentsTable tbody tr");

rows.forEach(function(row){

let text=row.innerText.toLowerCase();

row.style.display=text.includes(filter) ? "" : "none";

});

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>