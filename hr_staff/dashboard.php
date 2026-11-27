<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
include "../includes/mailer.php";
include "../includes/reminders.php";
if (function_exists("process_due_reminders")) { process_due_reminders($conn); }

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

    $remarks=mysqli_real_escape_string($conn,$_POST['remarks'] ?? '');

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

    require_once __DIR__ . '/../includes/notify_admins.php';
    notify_admins($conn, "HR marked " . $doc['first_name'] . " " . $doc['last_name'] . "'s document '" . $doc['document_title'] . "' as " . $status, 'status_update');

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

    $go = (isset($_POST['return_to']) && $_POST['return_to']==='documents.php') ? 'documents.php' : 'dashboard.php';
    header("Location: " . $go);

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

    <a href="documents.php"><i class="bi bi-folder2-open"></i> Documents</a>
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
<a href="templates.php"><i class="bi bi-file-earmark-arrow-down-fill"></i> Template</a>

    <a href="reports.php">
        <i class="bi bi-bar-chart-fill"></i>
        Reports
    </a>

    <a href="profile.php">
        <i class="bi bi-person-circle"></i>
        My Profile
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

Recent Submitted Documents

</h4>

</div>

<div class="table-responsive">

<table
class="table table-hover align-middle"
id="documentsTable">

<thead class="table-light">

<tr>

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

ORDER BY documents.submitted_at DESC, documents.document_id DESC

LIMIT 10

");

while($row=mysqli_fetch_assoc($query))
{

?>
<tr>

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


</td>
<td>
<?php
$st=$row['status'];
$badge=['Pending'=>'warning text-dark','Approved'=>'success','Rejected'=>'danger','Returned'=>'info text-dark'][$st] ?? 'secondary';
?>
<span class="badge bg-<?php echo $badge; ?>"><?php echo htmlspecialchars($st); ?></span>
</td>

<td>
<?php echo date("M d, Y",strtotime($row['submitted_at'])); ?>
</td>

<td>
<?php
echo !empty($row['hr_remarks'])
    ? nl2br(htmlspecialchars($row['hr_remarks']))
    : "<span class='text-muted'>No remarks</span>";
?>
</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

<script>

function statFilter(v){
    window.location.href = "documents.php" + (v ? "?status=" + encodeURIComponent(v) : "");
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function escapeHtml(str){
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

</script>
<script src="../assets/notifications.js"></script>

</body>

</html>