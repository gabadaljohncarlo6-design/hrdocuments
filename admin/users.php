<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

date_default_timezone_set("Asia/Manila");

$currentHour=(int)date("G");

if($currentHour>=5 && $currentHour<12)
{
    $greeting="Good Morning";
}
elseif($currentHour>=12 && $currentHour<18)
{
    $greeting="Good Afternoon";
}
else
{
    $greeting="Good Evening";
}

$departments = ['All','Computer Studies','HBM','BindTech','Education','Not Teaching','Others'];

$activeDept = isset($_GET['dept']) && in_array($_GET['dept'], $departments) ? $_GET['dept'] : 'All';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$where = "WHERE (employee_id LIKE '%$search%' OR first_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' OR role LIKE '%$search%')";

if ($activeDept !== 'All') {
    $where .= " AND department = '" . mysqli_real_escape_string($conn, $activeDept) . "'";
}

$query = mysqli_query($conn, "
SELECT *
FROM users
$where
ORDER BY role ASC, last_name ASC
");
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Users</title>

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

:root{
--blue:#0A2E73;
--yellow:#F5B400;
--shadow:0 10px 30px rgba(0,0,0,.08);
}

.sidebar{
position:fixed;
top:0;
left:0;
width:110px;
height:100vh;
background:linear-gradient(180deg,#0A2E73,#123c92);
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

.main{
margin-left:110px;
padding:30px;
}

.topbar{
background:#fff;
padding:20px 28px;
border-radius:18px;
box-shadow:var(--shadow);
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
}

.topbar h2{
margin:0;
font-weight:700;
color:#0A2E73;
}

.topbar small{
color:#666;
}

.admin-box img{
width:52px;
height:52px;
border-radius:50%;
}

.table-box{
background:#fff;
padding:25px;
border-radius:20px;
box-shadow:var(--shadow);
}

.table thead{
background:#0A2E73;
color:#fff;
}

.table th,
.table td{
white-space:nowrap;
}

.btn-action{
margin-right:5px;
}

.dept-tabs{
display:flex;
flex-wrap:wrap;
gap:8px;
margin-bottom:20px;
}

.dept-tabs a{
padding:8px 16px;
border-radius:999px;
background:#eef3fb;
color:#0A2E73;
text-decoration:none;
font-size:14px;
font-weight:500;
border:1.5px solid #dce4f5;
transition:.2s;
}

.dept-tabs a:hover{
background:#dce4f5;
}

.dept-tabs a.active{
background:#0A2E73;
color:#fff;
border-color:#0A2E73;
}

#searchStatus{
font-size:13px;
color:#888;
margin-top:6px;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="sidebar">

<a href="dashboard.php" title="Go to Dashboard" style="padding:0;margin:0 auto 4px;background:none;display:block;width:fit-content;text-decoration:none;"><img src="../images/isatu_logo.png"></a>

<h3>ISAT U HRMS</h3>

<p>Administrator Panel</p>

<a href="dashboard.php">
<i class="bi bi-speedometer2"></i>
Dashboard
</a>

<a href="users.php">
<i class="bi bi-people-fill"></i>
Manage Users
</a>
<a href="repository.php">
<i class="bi bi-folder-symlink-fill"></i>
File Repository
</a>

<a href="authorize_employee_ids.php">
<i class="bi bi-shield-check"></i>
Authorize IDs
</a>

<a href="activity_logs.php">
<i class="bi bi-clock-history"></i>
Activity Logs
</a>

<a href="reports.php">
<i class="bi bi-bar-chart-fill"></i>
Reports
</a>

<a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</div>

<div class="main">

<div class="topbar">

<div>

<h2>Manage Users</h2>

<small>

<?php echo $greeting; ?>

• Human Resource Document Management System

</small>

</div>

<div class="admin-box">

<img src="../images/isatu_logo.png">

</div>

</div>
<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h3 class="fw-bold">

<i class="bi bi-people-fill"></i>

Manage Users

</h3>

<p class="text-muted mb-0">

Manage all registered faculty, HR personnel and administrators.

</p>

</div>

<a
href="add_user.php"
class="btn btn-primary">

<i class="bi bi-person-plus-fill"></i>

Add User

</a>

</div>

<!-- Department Tabs -->
<div class="dept-tabs">
<?php foreach ($departments as $dept): ?>
    <a href="?dept=<?php echo urlencode($dept); ?><?php echo $search ? '&search='.urlencode($search) : ''; ?>"
       class="dept-tab-link <?php echo $activeDept === $dept ? 'active' : ''; ?>"
       data-dept="<?php echo htmlspecialchars($dept); ?>">
        <?php echo htmlspecialchars($dept); ?>
    </a>
<?php endforeach; ?>
</div>

<div class="row mb-2">

<div class="col-md-10">

<input
type="text"
id="liveSearch"
class="form-control"
placeholder="Search by Employee ID, Name, Email or Role... (live search)"
value="<?php echo htmlspecialchars($search); ?>">

<div id="searchStatus"></div>

</div>

<div class="col-md-2">

<a
href="users.php"
class="btn btn-secondary w-100">

Reset

</a>

</div>

</div>

<div class="table-responsive">
<table class="table table-hover align-middle">

<thead>

<tr>

<th>Employee ID</th>

<th>Full Name</th>

<th>Email</th>

<th>Department</th>

<th>Role</th>

<th>Status</th>

<th width="260">

Actions

</th>

</tr>

</thead>

<tbody id="usersTableBody">

<?php include "partials/users_rows.php"; ?>

</tbody>

</table>

</div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const searchInput = document.getElementById('liveSearch');
const tableBody = document.getElementById('usersTableBody');
const searchStatus = document.getElementById('searchStatus');
const deptTabs = document.querySelectorAll('.dept-tab-link');

let activeDept = "<?php echo htmlspecialchars($activeDept); ?>";
let debounceTimer;

function runSearch() {
    const term = searchInput.value.trim();
    searchStatus.textContent = "Searching...";

    fetch(`ajax_search_users.php?search=${encodeURIComponent(term)}&dept=${encodeURIComponent(activeDept)}`)
        .then(res => res.text())
        .then(html => {
            tableBody.innerHTML = html;
            searchStatus.textContent = "";
        })
        .catch(() => {
            searchStatus.textContent = "Search failed. Try again.";
        });
}

searchInput.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(runSearch, 300);
});

deptTabs.forEach(tab => {
    tab.addEventListener('click', function (e) {
        e.preventDefault();
        deptTabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        activeDept = this.dataset.dept;

        const url = new URL(window.location);
        url.searchParams.set('dept', activeDept);
        window.history.pushState({}, '', url);

        runSearch();
    });
});

function toggleStatus(userId, currentStatus) {
    if (!confirm('Change this user\'s status?')) return;

    fetch(`toggle_status.php?id=${userId}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                runSearch();
            } else {
                alert(data.message || 'Failed to update status.');
            }
        });
}
</script>

</body>

</html>