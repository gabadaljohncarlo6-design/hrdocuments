<?php
/*
|--------------------------------------------------------------------------
| TEMPLATE FILES (shared by admin/templates.php, hr_staff/templates.php,
| faculty/templates.php)
| Expects: $conn, $user_id, $tpl_can_manage (true for admin/HR, false for faculty)
| Admin/HR upload a file with a title; every faculty can download it.
|--------------------------------------------------------------------------
*/
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS file_templates (
    template_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size INT DEFAULT 0,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$tpl_dir = __DIR__ . '/../uploads/templates/';
if (!is_dir($tpl_dir)) { @mkdir($tpl_dir, 0777, true); }

$tpl_msg = "";

if ($tpl_can_manage && isset($_POST['upload_template'])) {
    $title = trim($_POST['title'] ?? '');
    $f = $_FILES['template_file'] ?? null;
    $allowed = ['pdf','doc','docx','xls','xlsx','ppt','pptx','jpg','jpeg','png','zip'];

    if ($title === '') {
        $tpl_msg = "<div class='alert alert-danger'>Please enter a title.</div>";
    } elseif (!$f || $f['error'] !== UPLOAD_ERR_OK) {
        $tpl_msg = "<div class='alert alert-danger'>Please choose a file to upload.</div>";
    } else {
        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            $tpl_msg = "<div class='alert alert-danger'>File type not allowed. Use PDF, Word, Excel, PowerPoint, image or ZIP.</div>";
        } elseif ($f['size'] > 10 * 1024 * 1024) {
            $tpl_msg = "<div class='alert alert-danger'>File is too large (max 10 MB).</div>";
        } else {
            $safe = preg_replace('/[^A-Za-z0-9._ -]/', '_', basename($f['name']));
            $stored = time() . '_' . $safe;
            if (move_uploaded_file($f['tmp_name'], $tpl_dir . $stored)) {
                $t  = mysqli_real_escape_string($conn, $title);
                $fn = mysqli_real_escape_string($conn, $safe);
                $fp = mysqli_real_escape_string($conn, $stored);
                $sz = (int)$f['size'];
                $by = (int)$user_id;
                mysqli_query($conn, "INSERT INTO file_templates (title, file_name, file_path, file_size, uploaded_by)
                                     VALUES ('$t', '$fn', '$fp', '$sz', '$by')");

                // tell every active faculty
                $nm = mysqli_real_escape_string($conn, "New template available: \"$title\". Open the Template page to download it.");
                mysqli_query($conn, "INSERT INTO notifications (user_id, message, type)
                                     SELECT user_id, '$nm', 'template' FROM users WHERE role='faculty' AND status='Active'");

                mysqli_query($conn, "INSERT INTO activity_logs (user_id, activity, module)
                                     VALUES ('$by', 'Uploaded template \"$t\"', 'Templates')");
                $tpl_msg = "<div class='alert alert-success'>Template uploaded and faculty were notified.</div>";
            } else {
                $tpl_msg = "<div class='alert alert-danger'>Upload failed. Check that the uploads/templates folder is writable.</div>";
            }
        }
    }
}

if ($tpl_can_manage && isset($_POST['delete_template'])) {
    $tid = (int)$_POST['template_id'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT file_path FROM file_templates WHERE template_id='$tid'"));
    if ($row) {
        @unlink($tpl_dir . $row['file_path']);
        mysqli_query($conn, "DELETE FROM file_templates WHERE template_id='$tid'");
        $tpl_msg = "<div class='alert alert-success'>Template deleted.</div>";
    }
}

function tpl_size($b) {
    $b = (float)$b;
    if ($b < 1024) return $b . ' B';
    if ($b < 1048576) return round($b / 1024, 1) . ' KB';
    return round($b / 1048576, 1) . ' MB';
}

$tpl_list = mysqli_query($conn, "SELECT t.*, u.first_name, u.last_name
    FROM file_templates t LEFT JOIN users u ON u.user_id = t.uploaded_by
    ORDER BY t.created_at DESC");
?>

<?php echo $tpl_msg; ?>

<?php if ($tpl_can_manage): ?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3"><i class="bi bi-cloud-upload-fill"></i> Upload a Template</h5>
        <form method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-5">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" maxlength="200" placeholder="e.g. Leave Application Form" required>
            </div>
            <div class="col-md-5">
                <label class="form-label">File</label>
                <input type="file" name="template_file" class="form-control" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" name="upload_template" class="btn btn-primary w-100">
                    <i class="bi bi-send-fill"></i> Send
                </button>
            </div>
            <div class="col-12"><small class="text-muted">The date is added automatically. Every faculty user will see it under Template and get a notification.</small></div>
        </form>
    </div>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="fw-bold mb-3"><i class="bi bi-file-earmark-text-fill"></i> Available Templates</h5>
        <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>File</th>
                    <?php if ($tpl_can_manage): ?><th>Sent by</th><?php endif; ?>
                    <th width="<?php echo $tpl_can_manage ? 170 : 120; ?>">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$tpl_list || mysqli_num_rows($tpl_list) === 0): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">No templates yet.</td></tr>
            <?php else: while ($t = mysqli_fetch_assoc($tpl_list)): ?>
                <tr>
                    <td><?php echo date("M j, Y", strtotime($t['created_at'])); ?></td>
                    <td><strong><?php echo htmlspecialchars($t['title']); ?></strong></td>
                    <td><?php echo htmlspecialchars($t['file_name']); ?> <small class="text-muted">(<?php echo tpl_size($t['file_size']); ?>)</small></td>
                    <?php if ($tpl_can_manage): ?>
                        <td><?php echo htmlspecialchars(trim(($t['first_name'] ?? '') . ' ' . ($t['last_name'] ?? '')) ?: '-'); ?></td>
                    <?php endif; ?>
                    <td>
                        <a class="btn btn-sm btn-success" download="<?php echo htmlspecialchars($t['file_name']); ?>"
                           href="../uploads/templates/<?php echo rawurlencode($t['file_path']); ?>">
                            <i class="bi bi-download"></i> Download
                        </a>
                        <?php if ($tpl_can_manage): ?>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this template?');">
                            <input type="hidden" name="template_id" value="<?php echo (int)$t['template_id']; ?>">
                            <button type="submit" name="delete_template" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash-fill"></i></button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>