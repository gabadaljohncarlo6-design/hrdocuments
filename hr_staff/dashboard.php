<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
include "../includes/mailer.php";

date_default_timezone_set("Asia/Manila");

/*
|--------------------------------------------------------------------------
| UPDATE DOCUMENT
|--------------------------------------------------------------------------
*/

if(isset($_POST['update']))
{

    $document_id=(int)$_POST['document_id'];

    $status=mysqli_real_escape_string($conn,$_POST['status']);

    $remarks=mysqli_real_escape_string($conn,$_POST['remarks']);

    mysqli_query($conn,"
    UPDATE documents
    SET
        status='$status',
        hr_remarks='$remarks'
    WHERE
        document_id='$document_id'
    ");

    $doc=mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT
        documents.user_id,
        documents.document_title,
        users.email,
        users.first_name,
        users.last_name
    FROM documents
    LEFT JOIN users ON users.user_id = documents.user_id
    WHERE
        documents.document_id='$document_id'
    "));

    $activity="Updated document '".$doc['document_title']."' to ".$status;

    mysqli_query($conn,"
    INSERT INTO activity_logs
    (
        user_id,
        activity
    )
    VALUES
    (
        '".$_SESSION['user_id']."',
        '".mysqli_real_escape_string($conn,$activity)."'
    )
    ");

    $message="Your document '".$doc['document_title']."' has been ".$status." by HR.";

    mysqli_query($conn,"
    INSERT INTO notifications
    (
        user_id,
        message,
        type
    )
    VALUES
    (
        '".$doc['user_id']."',
        '".mysqli_real_escape_string($conn,$message)."',
        'status_update'
    )
    ");

    if (!empty($doc['email'])) {
        $statusColor = "#0A2E73";
        if ($status === "Approved") $statusColor = "#28a745";
        elseif ($status === "Rejected") $statusColor = "#dc3545";
        elseif ($status === "Returned") $statusColor = "#17a2b8";

        $emailBody = "
            <p>Hello " . htmlspecialchars($doc['first_name']) . ",</p>
            <p>Your document <strong>\"" . htmlspecialchars($doc['document_title']) . "\"</strong> has been
            <strong style='color:{$statusColor};'>{$status}</strong> by the HR Office.</p>
            " . (!empty($remarks) ? "<p><strong>Remarks:</strong> " . nl2br(htmlspecialchars($remarks)) . "</p>" : "") . "
            <p>Please log in to the ISAT U HR Document Management System for more details.</p>
            <p>— ISAT U HR Office</p>
        ";

        send_notification_email(
            $conn,
            $doc['email'],
            $doc['first_name'] . ' ' . $doc['last_name'],
            "Document {$status}: " . $doc['document_title'],
            $emailBody
        );
    }

    header("Location: dashboard.php");

    exit();

}

/*
|--------------------------------------------------------------------------
| DASHBOARD COUNTS
|--------------------------------------------------------------------------
*/

$totalDocuments=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
"))[0];

$totalPending=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE status='Pending'
"))[0];

$totalApproved=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE status='Approved'
"))[0];

$totalReturned=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE status='Returned'
"))[0];

$totalRejected=mysqli_fetch_row(mysqli_query($conn,"
SELECT COUNT(*)
FROM documents
WHERE status='Rejected'
"))[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>HR Staff Dashboard</title>

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
width:110px;
height:100vh;
background:linear-gradient(180deg,#5b92e5,#2a63bd);
padding:16px 8px;
overflow-y:auto;
overflow-x:hidden;
z-index:999;
}

.sidebar img{
width:44px;
display:block;
margin:auto;
}

.sidebar h3{
color:#fff;
text-align:center;
margin-top:8px;
font-weight:700;
font-size:12px;
line-height:1.2;
}

.sidebar p{
color:#ddd;
text-align:center;
margin-bottom:18px;
font-size:10px;
}

.sidebar a{
display:flex;
flex-direction:column;
align-items:center;
justify-content:center;
gap:4px;
padding:10px 4px;
margin-bottom:8px;
text-decoration:none;
color:#fff;
border-radius:12px;
transition:.3s;
font-weight:500;
font-size:10.5px;
line-height:1.2;
text-align:center;
word-break:break-word;
white-space:normal;
}

.sidebar a i{
font-size:18px;
}

.sidebar a:hover{
background:#F5B400;
color:#000;
}

.sidebar a.active{
background:#F5B400;
color:#000;
}

.main{
margin-left:110px;
padding:30px;
}

.topbar{
background:#fff;
padding:20px 30px;
border-radius:18px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
}

.topbar h2{
margin:0;
font-size:28px;
font-weight:700;
color:#0A2E73;
}

.topbar p{
margin:0;
color:#666;
font-size:14px;
}

.stats{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
margin-bottom:30px;
}

.stat-card{
background:#fff;
border-radius:18px;
padding:25px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.stat-card h5{
color:#777;
margin-bottom:10px;
font-size:15px;
}

.stat-card h2{
margin:0;
font-size:34px;
font-weight:700;
color:#0A2E73;
}

.stat-card h2.text-blue{ color:#0A2E73; }
.stat-card h2.text-green{ color:#28a745; }
.stat-card h2.text-red{ color:#dc3545; }
.stat-card h2.text-yellow{ color:#F5B400; }

.chart-card{
background:#fff;
border-radius:18px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
padding:25px;
margin-bottom:30px;
}

.chart-card h4{
margin-bottom:20px;
font-weight:700;
color:#0A2E73;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
<style>.status-select{padding-right:2rem !important;min-width:125px;}</style>
</head>

<body>

<div class="sidebar">

    <a href="dashboard.php" title="Go to Dashboard" style="padding:0;margin:0 auto 4px;background:none;display:block;width:fit-content;text-decoration:none;"><img src="../images/isatu_logo.png"></a>

    <h3>ISAT U HRMS</h3>

    <p>HR Staff Panel</p>

    <a href="dashboard.php" class="active">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="deadlines.php">
        <i class="bi bi-calendar-event-fill"></i>
        Submission Deadlines
    </a>

    <a href="find_faculty.php">
        <i class="bi bi-people-fill"></i>
        Find Faculty
    </a>
<a href="repository.php">
        <i class="bi bi-folder-symlink-fill"></i>
        File Repository
    </a>

    <a href="reports.php">
        <i class="bi bi-bar-chart-fill"></i>
        Reports
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

<?php

$currentHour=date("G");

if($currentHour>=5 && $currentHour<12){
    $greeting="Good Morning";
}
elseif($currentHour>=12 && $currentHour<18){
    $greeting="Good Afternoon";
}
else{
    $greeting="Good Evening";
}

?>

<div class="topbar">

    <div>

        <h2><?php echo $greeting; ?>, HR Staff</h2>

        <p><?php echo date("l, F d, Y"); ?></p>

    </div>

    <div class="d-flex align-items-center gap-3">

    <div class="dropdown">
        <button class="btn position-relative" id="notifBell" data-bs-toggle="dropdown" style="border:none;background:none;">
            <i class="bi bi-bell-fill fs-4" style="color:#0A2E73;"></i>
            <span id="notifBadge" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" style="display:none;font-size:10px;">0</span>
        </button>
        <div class="dropdown-menu dropdown-menu-end p-0" style="width:340px;max-height:400px;overflow-y:auto;" id="notifDropdown">
            <div class="p-3 text-center text-muted">Loading...</div>
        </div>
    </div>

    <?php require_once __DIR__ . '/../includes/avatar.php'; echo topbar_avatar($conn); ?>

    </div>

</div>

<div class="stats">

<div class="stat-card stat-click" onclick="statFilter('')" role="button" title="Show all documents">
<h5>Total Documents</h5>
<h2 class="text-blue"><?php echo $totalDocuments; ?></h2>
</div>

<div class="stat-card stat-click" onclick="statFilter('Pending')" role="button" title="Show pending documents">
<h5>Pending</h5>
<h2 style="color:#fd7e14;"><?php echo $totalPending; ?></h2>
</div>

<div class="stat-card stat-click" onclick="statFilter('Approved')" role="button" title="Show approved documents">
<h5>Approved</h5>
<h2 class="text-green"><?php echo $totalApproved; ?></h2>
</div>

<div class="stat-card stat-click" onclick="statFilter('Rejected')" role="button" title="Show rejected documents">
<h5>Rejected</h5>
<h2 class="text-red"><?php echo $totalRejected; ?></h2>
</div>

<div class="stat-card stat-click" onclick="statFilter('Returned')" role="button" title="Show returned documents">
<h5>Returned</h5>
<h2 class="text-yellow"><?php echo $totalReturned; ?></h2>
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

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="fw-bold text-primary mb-0">

Submitted Documents

</h4>

<div class="d-flex gap-2 flex-wrap">

<input
type="text"
id="searchInput"
class="form-control"
style="width:240px;"
placeholder="Search Employee / Title">

<select
id="categoryFilter"
class="form-select"
style="width:180px;">

<option value="">

All Categories

</option>

<?php

$catQuery=mysqli_query($conn,"
SELECT category_name
FROM document_categories
ORDER BY category_name
");

while($cat=mysqli_fetch_assoc($catQuery))
{

?>

<option
value="<?php echo $cat['category_name']; ?>">

<?php echo $cat['category_name']; ?>

</option>

<?php

}

?>

</select>

<select
id="statusFilter"
class="form-select"
style="width:170px;">

<option value="">

All Status

</option>

<option value="Pending">

Pending

</option>

<option value="Approved">

Approved

</option>

<option value="Rejected">

Rejected

</option>

<option value="Returned">

Returned

</option>

</select>

<select
id="dateFilter"
class="form-select"
style="width:170px;">

<option value="">

All Dates

</option>

<option value="today">

Today

</option>

<option value="week">

This Week

</option>

<option value="month">

This Month

</option>

<option value="year">

This Year

</option>

</select>

</div>

</div>

<div class="table-responsive">

<table
class="table table-hover align-middle"
id="documentsTable">

<thead class="table-light">

<tr>

<th>ID</th>

<th>Employee</th>

<th>Category</th>

<th>Title</th>

<th>Faculty Comment</th>

<th>File</th>

<th>Status</th>

<th>Submitted</th>

<th>Remarks</th>

</tr>

</thead>

<tbody>

<?php
$query=mysqli_query($conn,"

SELECT

documents.*,

users.first_name,

users.last_name,

document_categories.category_name

FROM documents

LEFT JOIN users

ON users.user_id=documents.user_id

LEFT JOIN document_categories

ON document_categories.category_id=documents.category_id

ORDER BY documents.document_id DESC

");

while($row=mysqli_fetch_assoc($query))
{

?>
<tr>

<td><?php echo $row['document_id']; ?></td>

<td>
<?php echo $row['first_name']." ".$row['last_name']; ?>
</td>

<td>
<?php echo $row['category_name']; ?>
</td>

<td>
<?php echo $row['document_title']; ?>
</td>
<td>
<?php
echo !empty($row['faculty_comment'])
    ? nl2br(htmlspecialchars($row['faculty_comment']))
    : "<span class='text-muted'>No comment</span>";
?>
</td>
<td>

<a
href="<?php echo $row['file_path']; ?>"
target="_blank"
class="btn btn-primary btn-sm">

View

</a>

<a href="send_file.php?id=<?php echo (int)$row['document_id']; ?>" class="btn btn-warning btn-sm mt-1" title="Send corrected file to faculty"><i class="bi bi-send-fill"></i> Send File</a>

</td>
<td>
<?php
$st=$row['status'];
?>
<form id="f<?php echo (int)$row['document_id']; ?>" method="POST" style="display:none">
<input type="hidden" name="document_id" value="<?php echo (int)$row['document_id']; ?>">
<input type="hidden" name="update" value="1">
</form>
<select name="status" form="f<?php echo (int)$row['document_id']; ?>" class="form-select form-select-sm status-select" onchange="this.form.submit()">
<?php foreach(["Pending","Approved","Rejected","Returned"] as $opt){ ?>
<option value="<?php echo $opt; ?>" <?php if($st==$opt) echo "selected"; ?>><?php echo $opt; ?></option>
<?php } ?>
</select>
</td>

<td>
<?php echo date("M d, Y",strtotime($row['submitted_at'])); ?>
</td>

<td>
<input type="text" name="remarks" form="f<?php echo (int)$row['document_id']; ?>" class="form-control form-control-sm" placeholder="Type remarks, press Enter" value="<?php echo htmlspecialchars($row['hr_remarks']); ?>" onchange="this.form.submit()">
</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

<div class="chart-card">

<h4>

Documents by Category

</h4>

<canvas id="categoryChart"></canvas>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php

$chart=mysqli_query($conn,"
SELECT
document_categories.category_name,
COUNT(*) total
FROM documents
LEFT JOIN document_categories
ON document_categories.category_id=documents.category_id
GROUP BY document_categories.category_name
");

$categoryLabels=[];
$categoryCounts=[];

while($c=mysqli_fetch_assoc($chart))
{
    $categoryLabels[]=$c['category_name'];
    $categoryCounts[]=$c['total'];
}

?>

<script>

const ctx=document.getElementById("categoryChart");

if(ctx){

new Chart(ctx,{

type:"bar",

data:{

labels:<?php echo json_encode($categoryLabels); ?>,

datasets:[{

label:"Documents",

data:<?php echo json_encode($categoryCounts); ?>,

backgroundColor:"#0d6efd",

borderRadius:8

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true

}

}

}

});

}

const searchInput=document.getElementById("searchInput");
const categoryFilter=document.getElementById("categoryFilter");
const statusFilter=document.getElementById("statusFilter");
const dateFilter=document.getElementById("dateFilter");

function filterTable(){

let search=searchInput.value.toLowerCase();
let category=categoryFilter.value.toLowerCase();
let status=statusFilter.value.toLowerCase();
let date=dateFilter.value;

let today=new Date();

document.querySelectorAll("#documentsTable tbody tr").forEach(function(row){

let employee=row.cells[1].innerText.toLowerCase();
let categoryText=row.cells[2].innerText.toLowerCase();
let title=row.cells[3].innerText.toLowerCase();

let statusText=row.cells[6]
.querySelector("select")
.value
.toLowerCase();

let submitted=new Date(row.cells[7].innerText);

let matchSearch=
employee.includes(search)||
title.includes(search)||
categoryText.includes(search);

let matchCategory=
category===""||
categoryText===category;

let matchStatus=
status===""||
statusText===status;

let matchDate=true;

if(date==="today")
{

matchDate=submitted.toDateString()===today.toDateString();

}

if(date==="week")
{

let weekAgo=new Date();

weekAgo.setDate(today.getDate()-7);

matchDate=submitted>=weekAgo;

}

if(date==="month")
{

matchDate=
submitted.getMonth()===today.getMonth()&&
submitted.getFullYear()===today.getFullYear();

}

if(date==="year")
{

matchDate=
submitted.getFullYear()===today.getFullYear();

}

row.style.display=

(matchSearch&&matchCategory&&matchStatus&&matchDate)

?

""

:

"none";

});

}

searchInput.addEventListener("keyup",filterTable);
categoryFilter.addEventListener("change",filterTable);
statusFilter.addEventListener("change",filterTable);

function statFilter(v){
    statusFilter.value=v;
    filterTable();
    statusFilter.scrollIntoView({behavior:"smooth",block:"center"});
}
dateFilter.addEventListener("change",filterTable);

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function escapeHtml(str){
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

function loadNotifications(){
    fetch('../notifications_ajax.php')
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('notifBadge');
            if (data.unread_count > 0) {
                badge.style.display = 'inline-block';
                badge.textContent = data.unread_count > 9 ? '9+' : data.unread_count;
            } else {
                badge.style.display = 'none';
            }

            const dropdown = document.getElementById('notifDropdown');
            if (!data.notifications || data.notifications.length === 0) {
                dropdown.innerHTML = '<div class="p-3 text-center text-muted">No notifications yet.</div>';
                return;
            }

            dropdown.innerHTML = data.notifications.map(n => `
                <a href="#" class="dropdown-item ${n.is_read ? '' : 'bg-light'} py-2 border-bottom" onclick="markNotifRead(${n.id}); return false;">
                    <div style="font-size:13px;white-space:normal;">${escapeHtml(n.message)}</div>
                    <small class="text-muted">${n.time}</small>
                </a>
            `).join('');
        })
        .catch(() => {});
}

function markNotifRead(id){
    fetch('../mark_notifications_read.php?id=' + id).then(() => loadNotifications());
}

document.getElementById('notifBell').addEventListener('click', loadNotifications);
loadNotifications();
setInterval(loadNotifications, 30000);
</script>

</body>

</html>