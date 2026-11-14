<?php

date_default_timezone_set("Asia/Manila");

$currentHour = date("G");

if($currentHour >= 5 && $currentHour < 12)
{
    $greeting = "Good Morning";
}
elseif($currentHour >= 12 && $currentHour < 18)
{
    $greeting = "Good Afternoon";
}
else
{
    $greeting = "Good Evening";
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

ISAT U Human Resource Management System

</title>

<link rel="icon"
href="../images/isatu_logo.png">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
rel="stylesheet">

<style>

body{

    background:#eef3fb;

    font-family:'Poppins',sans-serif;

}

.main-content{

    margin-left:110px;

    padding:30px 40px;

    width:calc(100% - 110px);

}

.topbar{

    background:#ffffff;

    border-radius:18px;

    padding:18px 30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    box-shadow:0 10px 25px rgba(0,0,0,.08);

    margin-bottom:30px;

}

.topbar h2{

    margin:0;

    color:#0A2E73;

    font-weight:700;

}

.topbar p{

    margin:0;

    color:#666;

    font-size:14px;

}

.admin-info{

    display:flex;

    align-items:center;

    gap:15px;

}

.admin-info img{

    width:55px;

    height:55px;

    border-radius:50%;

}

.admin-info span{

    font-weight:600;

    color:#0A2E73;

}

/* ===========================
   FACULTY PROFILE
=========================== */

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.profile-card{
    background:#fff;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
    padding:30px;
    height:100%;
    position:sticky;
    top:50px;
}

.profile-top{
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    margin-bottom:25px;
}

.avatar{
    width:100px;
    height:100px;
    border-radius:50%;
    background:#0d6efd;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:40px;
    font-weight:bold;
}   

.profile-name h2{
    font-size:24px;
    font-weight:700;
    color:#123b84;
    margin-top:15px;
}

.profile-name p{
    margin-top:5px;
    color:#777;
    text-transform:capitalize;
}

.profile-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:30px;
    margin-top:30px;
}

.profile-grid label{
    display:block;
    color:#888;
    font-size:13px;
    margin-bottom:5px;
    font-weight:600;
}

.profile-grid p{
    margin:0;
    font-size:16px;
    font-weight:600;
    color:#222;
    overflow-wrap:break-word;
    word-break:break-word;
}

.card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.card-header h2{
    margin:0;
    font-size:24px;
    color:#123b84;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th{
    background:#f8f9fa;
    padding:14px;
    text-align:left;
    font-weight:700;
}

.table td{
    padding:14px;
    border-top:1px solid #eee;
    vertical-align:middle;
}

.table tr:hover{
    background:#f7fbff;
}

.badge{
    padding:8px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}

.btn{
    padding:8px 15px;
    border-radius:8px;
    text-decoration:none;
}

.btn-primary{
    background:#0d6efd;
    color:#fff;
}

.btn-secondary{
    background:#6c757d;
    color:#fff;
}

.btn-primary:hover,
.btn-secondary:hover{
    opacity:.9;
}

@media(max-width:900px){

.profile-grid{
grid-template-columns:1fr;
}

.profile-top{
flex-direction:column;
text-align:center;
}

}

</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="main-content">

<div class="topbar">

<div>

<h2>

<?php echo $greeting; ?>, ISAT U HR ADMIN

</h2>

<p>

<?php echo date("l, F d, Y"); ?>

</p>

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

<div class="admin-info">

<?php require_once __DIR__ . '/../../includes/avatar.php'; echo topbar_avatar($conn); ?>

<span>

Administrator

</span>

</div>

</div>

</div>

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
    fetch('../mark_notifications.php?id=' + id).then(() => loadNotifications());
}

document.getElementById('notifBell').addEventListener('click', loadNotifications);
loadNotifications();
setInterval(loadNotifications, 30000);
</script>