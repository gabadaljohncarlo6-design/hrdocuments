<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr')
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
include "../includes/mailer.php";
include "../includes/reminders.php";

process_due_weekly_reminders($conn);

$message = "";

if (isset($_POST['post_deadline'])) {

    $category_id = (int)$_POST['category_id'];
    $deadline_date = mysqli_real_escape_string($conn, $_POST['deadline_date']);
    $deadline_time = mysqli_real_escape_string($conn, $_POST['deadline_time']);
    $note = mysqli_real_escape_string($conn, $_POST['message']);
    $hr_id = (int)$_SESSION['user_id'];
    $weekly_reminder = isset($_POST['weekly_reminder']) ? 1 : 0;

    $catResult = mysqli_query($conn, "SELECT category_name FROM document_categories WHERE category_id = '$category_id'");
    $cat = mysqli_fetch_assoc($catResult);

    if (!$cat) {
        $message = "<div class='alert alert-danger'>Invalid document category.</div>";
    } else {

        mysqli_query($conn, "
        INSERT INTO submission_deadlines (category_id, deadline_date, deadline_time, message, created_by, status, weekly_reminder)
        VALUES ('$category_id', '$deadline_date', '$deadline_time', '$note', '$hr_id', 'Active', '$weekly_reminder')
        ");

        $deadline_id = mysqli_insert_id($conn);

        $niceDate = date("F j, Y", strtotime($deadline_date));
        $niceTime = date("g:i A", strtotime($deadline_time));
        $catName = $cat['category_name'];

        $notifMessage = mysqli_real_escape_string(
            $conn,
            "New deadline: submit your \"$catName\" by $niceDate, $niceTime." . ($note ? " Note: $note" : "")
        );

        // Notify every active faculty account (in-app + email)
        $facultyResult = mysqli_query($conn, "SELECT user_id, first_name, last_name, email FROM users WHERE role = 'faculty' AND status = 'Active'");

        $recipients = [];
        $facultyIds = [];

        while ($f = mysqli_fetch_assoc($facultyResult)) {
            mysqli_query($conn, "
            INSERT INTO notifications (user_id, message, type)
            VALUES ('{$f['user_id']}', '$notifMessage', 'deadline')
            ");

            $recipients[] = ['email' => $f['email'], 'name' => $f['first_name'].' '.$f['last_name']];
            $facultyIds[] = $f['user_id'];
        }

        $emailBody = "
            <p>Hello,</p>
            <p>A new submission deadline has been posted by the HR Office:</p>
            <p><strong>Document:</strong> {$catName}<br>
               <strong>Deadline:</strong> {$niceDate}, {$niceTime}</p>
            " . ($note ? "<p><strong>Note:</strong> {$note}</p>" : "") . "
            <p>Please log in to the ISAT U HR Document Management System to submit your document.</p>
            <p>— ISAT U HR Office</p>
        ";

        if (!empty($recipients)) {
            send_bulk_notification_email(
                $conn,
                $recipients,
                "New Deadline: $catName submission due $niceDate",
                $emailBody
            );

            // Mark this batch of notifications as emailed
            $idsList = implode(',', $facultyIds);
            mysqli_query($conn, "
            UPDATE notifications
            SET email_sent = 1
            WHERE type = 'deadline'
              AND message = '$notifMessage'
              AND user_id IN ($idsList)
            ");
        }

        mysqli_query($conn, "
        INSERT INTO activity_logs (user_id, activity, module)
        VALUES ('$hr_id', 'Posted a submission deadline for \"$catName\" ($niceDate)', 'Deadlines')
        ");

        $message = "<div class='alert alert-success'>Deadline posted and all faculty notified.</div>";
    }
}

$categories = mysqli_query($conn, "SELECT * FROM document_categories ORDER BY category_name ASC");

$deadlines = mysqli_query($conn, "
SELECT sd.*, dc.category_name,
    (SELECT COUNT(*) FROM users WHERE role='faculty' AND status='Active') AS total_faculty,
    (SELECT COUNT(DISTINCT d.user_id) FROM documents d WHERE d.category_id = sd.category_id AND d.submitted_at >= sd.created_at) AS submitted_count
FROM submission_deadlines sd
JOIN document_categories dc ON dc.category_id = sd.category_id
ORDER BY sd.deadline_date DESC, sd.deadline_time DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Submission Deadlines</title>
<link rel="icon" href="../images/isatu_logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#eef3fb;overflow-x:hidden;}
.sidebar{position:fixed;left:0;top:0;width:210px;height:100vh;background:linear-gradient(180deg,#0A2E73,#123C92);padding:25px;overflow-y:auto;}
.sidebar img{width:90px;display:block;margin:auto;}
.sidebar h3{color:#fff;text-align:center;margin-top:15px;font-weight:700;}
.sidebar p{color:#ddd;text-align:center;margin-bottom:35px;font-size:14px;}
.sidebar a{display:flex;align-items:center;gap:14px;padding:14px 18px;margin-bottom:10px;text-decoration:none;color:#fff;border-radius:12px;transition:.3s;font-weight:500;}
.sidebar a:hover{background:#F5B400;color:#000;}
.sidebar a.active{background:#F5B400;color:#000;}
.main{margin-left:210px;padding:30px;}
.topbar{background:#fff;padding:20px 30px;border-radius:18px;box-shadow:0 8px 20px rgba(0,0,0,.08);display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;}
.topbar h2{margin:0;font-size:28px;font-weight:700;color:#0A2E73;}
.card-box{background:#fff;padding:25px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,.08);margin-bottom:25px;}
.table thead{background:#0A2E73;color:#fff;}
.progress{height:20px;border-radius:10px;}
</style>
<link rel="stylesheet" href="../assets/ui.css">
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php" title="Go to Dashboard" style="padding:0;margin:0 auto 4px;background:none;display:block;width:fit-content;text-decoration:none;"><img src="../images/isatu_logo.png"></a>
    <h3>ISAT U HRMS</h3>
    <p>HR Staff Panel</p>

    <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="deadlines.php" class="active"><i class="bi bi-calendar-event-fill"></i> Submission Deadlines</a>
    <a href="find_faculty.php"><i class="bi bi-people-fill"></i> Find Faculty</a>
<a href="repository.php"><i class="bi bi-folder-symlink-fill"></i> File Repository</a>
    <a href="reports.php"><i class="bi bi-bar-chart-fill"></i> Reports</a>
    <a href="profile.php"><i class="bi bi-person-circle"></i> My Profile</a>
    <a href="change_password.php"><i class="bi bi-key-fill"></i> Change Password</a>
    <a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">

<div class="topbar">
    <div>
        <h2>Submission Deadlines</h2>
        <p class="text-muted mb-0">Post a deadline for a document type and notify all faculty.</p>
    </div>
</div>

<?php echo $message; ?>

<div class="card-box">
    <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle"></i> Post New Deadline</h5>

    <form method="POST" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Document Type</label>
            <select name="category_id" class="form-select" required>
                <option value="" selected disabled>Select document</option>
                <?php while ($c = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?php echo $c['category_id']; ?>"><?php echo htmlspecialchars($c['category_name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Deadline Date</label>
            <input type="date" name="deadline_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Deadline Time</label>
            <input type="time" name="deadline_time" class="form-control" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" name="post_deadline" class="btn btn-primary w-100">
                <i class="bi bi-bell-fill"></i> Post &amp; Notify
            </button>
        </div>

        <div class="col-12">
            <label class="form-label">Note (optional)</label>
            <input type="text" name="message" class="form-control" placeholder="e.g. Submit to the HR office window, incomplete forms will be returned">
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="weekly_reminder" value="1" id="weeklyReminder">
                <label class="form-check-label" for="weeklyReminder">
                    Send a weekly reminder to faculty who haven't submitted yet (repeats every 7 days until the deadline)
                </label>
            </div>
        </div>
    </form>
</div>

<div class="card-box">
    <h5 class="fw-bold mb-3"><i class="bi bi-list-check"></i> Posted Deadlines</h5>

    <div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Document</th>
                <th>Deadline</th>
                <th>Note</th>
                <th>Submission Progress</th>
                <th>Weekly Reminder</th>
                <th width="140">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($deadlines) === 0): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">No deadlines posted yet.</td></tr>
        <?php else: while ($d = mysqli_fetch_assoc($deadlines)):
            $total = max((int)$d['total_faculty'], 1);
            $submitted = (int)$d['submitted_count'];
            $pct = round(($submitted / $total) * 100);
            $isPast = strtotime($d['deadline_date'].' '.$d['deadline_time']) < time();
        ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($d['category_name']); ?></strong></td>
                <td>
                    <?php echo date("M j, Y", strtotime($d['deadline_date'])); ?>
                    at <?php echo date("g:i A", strtotime($d['deadline_time'])); ?>
                    <?php if ($isPast): ?>
                        <span class="badge bg-secondary ms-1">Past due</span>
                    <?php else: ?>
                        <span class="badge bg-success ms-1">Upcoming</span>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($d['message'] ?: '—'); ?></td>
                <td style="min-width:200px;">
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width:<?php echo $pct; ?>%"><?php echo $pct; ?>%</div>
                    </div>
                    <small class="text-muted"><?php echo $submitted; ?> of <?php echo $d['total_faculty']; ?> faculty submitted</small>
                </td>
                <td>
                    <?php if ($d['weekly_reminder']): ?>
                        <span class="badge bg-success mb-1">On</span><br>
                        <small class="text-muted">
                            Last sent: <?php echo $d['last_reminder_sent'] ? date("M j, g:i A", strtotime($d['last_reminder_sent'])) : 'Not yet sent'; ?>
                        </small><br>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="sendReminderNow(<?php echo $d['deadline_id']; ?>, this)">
                            <i class="bi bi-send-fill"></i> Send Now
                        </button>
                    <?php else: ?>
                        <span class="badge bg-secondary">Off</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="deadline_submissions.php?id=<?php echo $d['deadline_id']; ?>" class="btn btn-sm btn-info">
                        <i class="bi bi-eye-fill"></i> View
                    </a>
                </td>
            </tr>
        <?php endwhile; endif; ?>
        </tbody>
    </table>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function sendReminderNow(deadlineId, btn) {
    if (!confirm('Send reminder now to everyone who has not submitted yet?')) return;

    btn.disabled = true;
    btn.innerHTML = 'Sending...';

    fetch(`send_reminder.php?id=${deadlineId}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(`Reminder sent to ${data.notified} faculty member(s).`);
                location.reload();
            } else {
                alert(data.message || 'Failed to send reminder.');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-send-fill"></i> Send Now';
            }
        })
        .catch(() => {
            alert('Something went wrong.');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-send-fill"></i> Send Now';
        });
}
</script>
</body>
</html>