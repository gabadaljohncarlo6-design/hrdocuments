<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr')
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
include "../includes/mailer.php";
date_default_timezone_set("Asia/Manila");

$doc_id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($conn, "
    SELECT d.*, u.first_name, u.last_name, u.email, u.employee_id, c.category_name
    FROM documents d
    JOIN users u ON u.user_id = d.user_id
    LEFT JOIN document_categories c ON c.category_id = d.category_id
    WHERE d.document_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $doc_id);
mysqli_stmt_execute($stmt);
$doc = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if(!$doc)
{
    header("Location: dashboard.php");
    exit();
}

$tableReady = false;
$chk = mysqli_query($conn, "SHOW TABLES LIKE 'hr_returned_files'");
if($chk && mysqli_num_rows($chk) > 0) { $tableReady = true; }

$error = "";
$success = isset($_GET['sent']) ? "File sent to the faculty successfully." : "";

if($_SERVER['REQUEST_METHOD'] === 'POST' && $tableReady)
{
    $note = trim($_POST['note'] ?? '');
    $allowed = ['pdf','doc','docx','jpg','jpeg','png'];
    $maxSize = 10 * 1024 * 1024;

    if(!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK)
    {
        $error = "Please choose a file to send (max 10 MB).";
    }
    else
    {
        $orig = basename($_FILES['file']['name']);
        $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
        $size = (int)$_FILES['file']['size'];

        if(!in_array($ext, $allowed, true))
        {
            $error = "Only PDF, DOC, DOCX, JPG, JPEG and PNG files are allowed.";
        }
        elseif($size > $maxSize)
        {
            $error = "File is too large. Maximum is 10 MB.";
        }
        else
        {
            $dir = __DIR__ . "/../uploads/hr_returns/";
            if(!is_dir($dir)) { mkdir($dir, 0755, true); }

            $stored = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
            $dbPath = "../uploads/hr_returns/" . $stored;

            if(move_uploaded_file($_FILES['file']['tmp_name'], $dir . $stored))
            {
                $hr_id = (int)$_SESSION['user_id'];
                $ins = mysqli_prepare($conn, "
                    INSERT INTO hr_returned_files (document_id, hr_user_id, file_name, file_path, file_size, note)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                mysqli_stmt_bind_param($ins, "iissis", $doc_id, $hr_id, $orig, $dbPath, $size, $note);
                mysqli_stmt_execute($ins);

                // Notify faculty (bell)
                $msg = "HR sent you an updated file for '" . $doc['document_title'] . "'. Check My Documents.";
                $n = mysqli_prepare($conn, "INSERT INTO notifications (user_id, message, type) VALUES (?, ?, 'hr_file')");
                mysqli_stmt_bind_param($n, "is", $doc['user_id'], $msg);
                mysqli_stmt_execute($n);

                // Audit trail
                $act = "Sent file '" . $orig . "' to " . $doc['first_name'] . " " . $doc['last_name'] . " for document '" . $doc['document_title'] . "'";
                $l = mysqli_prepare($conn, "INSERT INTO activity_logs (user_id, activity) VALUES (?, ?)");
                mysqli_stmt_bind_param($l, "is", $hr_id, $act);
                mysqli_stmt_execute($l);

                // Email
                if(!empty($doc['email']))
                {
                    $body = "
                        <p>Hello " . htmlspecialchars($doc['first_name']) . ",</p>
                        <p>The HR Office has sent you an updated file for your document
                        <strong>\"" . htmlspecialchars($doc['document_title']) . "\"</strong>.</p>
                        " . ($note !== '' ? "<p><strong>Note from HR:</strong> " . nl2br(htmlspecialchars($note)) . "</p>" : "") . "
                        <p>Please log in to the ISAT U HR Document Management System and open <em>My Documents</em> to download it.</p>
                        <p>— ISAT U HR Office</p>
                    ";
                    send_notification_email(
                        $conn,
                        $doc['email'],
                        $doc['first_name'] . ' ' . $doc['last_name'],
                        "HR sent you a file: " . $doc['document_title'],
                        $body
                    );
                }

                header("Location: send_file.php?id=" . $doc_id . "&sent=1");
                exit();
            }
            else
            {
                $error = "Upload failed. Please try again.";
            }
        }
    }
}

$history = [];
if($tableReady)
{
    $h = mysqli_prepare($conn, "
        SELECT r.*, CONCAT(u.first_name,' ',u.last_name) AS sent_by
        FROM hr_returned_files r
        LEFT JOIN users u ON u.user_id = r.hr_user_id
        WHERE r.document_id = ?
        ORDER BY r.return_id DESC
    ");
    mysqli_stmt_bind_param($h, "i", $doc_id);
    mysqli_stmt_execute($h);
    $res = mysqli_stmt_get_result($h);
    while($x = mysqli_fetch_assoc($res)) { $history[] = $x; }
}

$origName = preg_replace('/^\d+_/', '', $doc['file_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Send File to Faculty</title>
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
.box{background:#fff;border-radius:12px;padding:18px;box-shadow:0 4px 14px rgba(10,46,115,.08);}
</style>
<link rel="stylesheet" href="../assets/ui.css">
</head>
<body>

<div class="sidebar">
    <img src="../images/isatu_logo.png">
    <h3>ISAT U HRMS</h3>
    <p>HR Staff Panel</p>
    <a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="deadlines.php"><i class="bi bi-calendar-event-fill"></i> Submission Deadlines</a>
    <a href="find_faculty.php"><i class="bi bi-people-fill"></i> Find Faculty</a>
    <a href="repository.php"><i class="bi bi-folder-symlink-fill"></i> File Repository</a>
    <a href="reports.php"><i class="bi bi-bar-chart-fill"></i> Reports</a>
    <a href="profile.php"><i class="bi bi-person-circle"></i> My Profile</a>
    <a href="change_password.php"><i class="bi bi-key-fill"></i> Change Password</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">

<div class="topbar d-flex justify-content-between align-items-center">
    <div>
        <h2>Send File to Faculty</h2>
        <p class="text-muted mb-0">Upload the corrected or updated file and send it back to the faculty.</p>
    </div>
    <a href="dashboard.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<?php if($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
<?php if($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<?php if(!$tableReady): ?>
<div class="alert alert-warning">The database table for this feature is missing. Run <b>migration_v6.sql</b> in phpMyAdmin first.</div>
<?php endif; ?>

<div class="row g-3">

<div class="col-lg-5">
    <div class="box">
        <h5 class="mb-3"><i class="bi bi-file-earmark-text"></i> Faculty's Document</h5>
        <table class="table table-sm mb-3">
            <tr><th style="width:38%">Faculty</th><td><?php echo htmlspecialchars($doc['first_name'].' '.$doc['last_name']); ?></td></tr>
            <tr><th>Employee ID</th><td><?php echo htmlspecialchars($doc['employee_id'] ?: '-'); ?></td></tr>
            <tr><th>Title</th><td><?php echo htmlspecialchars($doc['document_title']); ?></td></tr>
            <tr><th>Category</th><td><?php echo htmlspecialchars($doc['category_name'] ?? '-'); ?></td></tr>
            <tr><th>Status</th><td><?php echo htmlspecialchars($doc['status']); ?></td></tr>
            <tr><th>Submitted</th><td><?php echo date("M d, Y h:i A", strtotime($doc['submitted_at'])); ?></td></tr>
            <tr><th>Faculty comment</th><td><?php echo $doc['faculty_comment'] ? nl2br(htmlspecialchars($doc['faculty_comment'])) : '<span class="text-muted">None</span>'; ?></td></tr>
        </table>
        <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank" class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i> View</a>
        <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" download="<?php echo htmlspecialchars($origName); ?>" class="btn btn-secondary btn-sm"><i class="bi bi-download"></i> Download original</a>
    </div>
</div>

<div class="col-lg-7">
    <div class="box mb-3">
        <h5 class="mb-3"><i class="bi bi-send-fill"></i> Send updated file</h5>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">File (PDF, DOC, DOCX, JPG, PNG - max 10 MB)</label>
                <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required <?php echo $tableReady ? '' : 'disabled'; ?>>
            </div>
            <div class="mb-3">
                <label class="form-label">Note to faculty (optional)</label>
                <textarea name="note" rows="3" class="form-control" placeholder="Example: I corrected the signature page. Please use this version." <?php echo $tableReady ? '' : 'disabled'; ?>></textarea>
            </div>
            <button type="submit" class="btn btn-primary" <?php echo $tableReady ? '' : 'disabled'; ?>>
                <i class="bi bi-send-fill"></i> Send to <?php echo htmlspecialchars($doc['first_name']); ?>
            </button>
            <div class="form-text mt-2">The faculty gets a notification and an email, and can download the file in My Documents.</div>
        </form>
    </div>

    <div class="box">
        <h5 class="mb-3"><i class="bi bi-clock-history"></i> Files already sent</h5>
        <?php if(!$history): ?>
            <p class="text-muted mb-0">Nothing sent yet for this document.</p>
        <?php else: ?>
        <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead><tr><th>File</th><th>Note</th><th>Sent</th><th></th></tr></thead>
            <tbody>
            <?php foreach($history as $x): ?>
            <tr>
                <td><?php echo htmlspecialchars($x['file_name']); ?><br><small class="text-muted"><?php echo htmlspecialchars($x['sent_by'] ?? ''); ?></small></td>
                <td><?php echo $x['note'] ? htmlspecialchars($x['note']) : '<span class="text-muted">-</span>'; ?></td>
                <td><?php echo date("M d, Y h:i A", strtotime($x['sent_at'])); ?></td>
                <td><a href="<?php echo htmlspecialchars($x['file_path']); ?>" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-eye-fill"></i></a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <?php endif; ?>
    </div>
</div>

</div>
</div>
</body>
</html>