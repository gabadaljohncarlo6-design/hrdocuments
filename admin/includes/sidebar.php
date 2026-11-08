<div class="sidebar">

    <div class="logo-area">

        <img src="../images/isatu_logo.png" class="logo">

        <h2>ISAT U</h2>

        <p>Human Resource Management System</p>

    </div>

    <hr>

    <ul class="menu">

        <li>
            <a href="../admin/dashboard.php">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="profile.php">
                <i class="bi bi-person-circle"></i>
                <span>My Profile</span>
            </a>
        </li>

        <li>
            <a href="../admin/documents.php">
                <i class="bi bi-folder2-open"></i>
                <span>Documents</span>
            </a>
        </li>
<li>
            <a href="../admin/repository.php">
                <i class="bi bi-folder-symlink-fill"></i>
                <span>File Repository</span>
            </a>
        </li>

        <li>
            <a href="../admin/users.php">
                <i class="bi bi-people-fill"></i>
                <span>Manage Users</span>
            </a>
        </li>

        <li>
            <a href="../admin/authorize_employee_ids.php">
                <i class="bi bi-shield-check"></i>
                <span>Authorize IDs</span>
            </a>
        </li>

        <li>
            <a href="../admin/activity_logs.php">
                <i class="bi bi-clock-history"></i>
                <span>Activity Logs</span>
            </a>
        </li>

        <li>
            <a href="../admin/reports.php">
                <i class="bi bi-bar-chart-fill"></i>
                <span>Reports and Analytics</span>
            </a>
        </li>

        <li>
            <a href="../admin/storage_analytics.php">
                <i class="bi bi-hdd-fill"></i>
                <span>Storage Analytics</span>
            </a>
        </li>

        <li>
            <a href="print_report.php" target="_blank">
                <i class="bi bi-printer-fill"></i>
                <span>Print Report</span>
            </a>
        </li>

        <li>
            <a href="export_pdf.php" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                <span>Export PDF</span>
            </a>
        </li>

        <li>
            <a href="settings.php">
                <i class="bi bi-gear-fill"></i>
                <span>Settings</span>
            </a>
        </li>

        <li>
            <a href="maintinance.php">
                <i class="bi bi-tools"></i>
                <span>Maintenance</span>
            </a>
        </li>

        <li>
            <a href="backup_database.php">
                <i class="bi bi-database-fill-down"></i>
                <span>Backup Database</span>
            </a>
        </li>

        <li>
            <a href="system_logs.php">
                <i class="bi bi-journal-text"></i>
                <span>System Logs</span>
            </a>
        </li>

        <li>
            <a href="database_status.php">
                <i class="bi bi-server"></i>
                <span>Database Status</span>
            </a>
        </li>

        <li>
            <a href="system_information.php">
                <i class="bi bi-info-circle-fill"></i>
                <span>System Information</span>
            </a>
        </li>

        <li>
            <a href="about.php">
                <i class="bi bi-info-square-fill"></i>
                <span>About System</span>
            </a>
        </li>

        <li>
            <a href="notifications.php">
                <i class="bi bi-bell-fill"></i>
                <span>Notifications</span>
            </a>
        </li>

        <li>
            <a href="announcement.php">
                <i class="bi bi-megaphone-fill"></i>
                <span>Announcements</span>
            </a>
        </li>

        <li>
            <a href="archive_documents.php">
                <i class="bi bi-archive-fill"></i>
                <span>Archived Documents</span>
            </a>
        </li>

    </ul>

    <div class="logout-area">

        <a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')" class="logout-btn">

            <i class="bi bi-box-arrow-right"></i>

            Logout

        </a>

    </div>

</div>
<style>

:root{

    --blue:#0A2E73;
    --yellow:#F5B400;
    --white:#ffffff;
    --bg:#eef3fb;
    --shadow:0 12px 30px rgba(2, 10, 118, 0.08);

}

*{

    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;

}

body{

    background:var(--bg);

}

.sidebar{

    position:fixed;

    top:0;
    left:0;

    width:210px;
    height:100vh;

    background:linear-gradient(180deg,#5b92e5,#2a63bd);

    color:white;

    padding:25px;

    overflow-y:auto;

    box-shadow:var(--shadow);

    padding-bottom:30px;

}

.logo-area{

    text-align:center;

}

.logo{

    width:90px;
    height:90px;

    object-fit:contain;

    margin-bottom:12px;

}

.logo-area h2{

    font-size:28px;

    font-weight:700;

    margin-bottom:5px;

}

.logo-area p{

    font-size:13px;

    color:#dcdcdc;

    line-height:20px;

}

.sidebar hr{

    border-color:rgba(255, 255, 255, 0.18);

    margin:25px 0;

}

.menu{

    list-style:none;

    padding:0;

}

.menu li{

    margin-bottom:10px;

}

.menu a{

    display:flex;

    align-items:center;

    gap:15px;

    color:white;

    text-decoration:none;

    padding:14px 18px;

    border-radius:14px;

    transition:.30s;

    font-size:16px;

    font-weight:500;

}

.menu a i{

    font-size:20px;

    width:25px;

    text-align:center;

}

.menu a:hover{

    background:var(--yellow);

    color:#000;

    transform:translateX(6px);

}

.logout-area{

    margin-top:25px;

}

.logout-btn{

    display:flex;

    justify-content:center;

    align-items:center;

    gap:10px;

    text-decoration:none;

    background:#dc3545;

    color:white;

    padding:14px;

    border-radius:14px;

    font-weight:600;

    transition:.3s;

}

.logout-btn:hover{

    background:#bb2d3b;

    color:white;

}

</style>