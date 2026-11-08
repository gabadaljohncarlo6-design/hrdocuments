<?php
/*
|--------------------------------------------------------------------------
| FILE REPOSITORY (shared by hr_staff/repository.php and admin/repository.php)
| Expects: $conn, $repo_self (page file name), $repo_profile_url (faculty profile link prefix)
|--------------------------------------------------------------------------
*/
if (!function_exists('repo_icon')) {
    function repo_icon($name) {
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if ($ext === 'pdf') return ['bi-file-earmark-pdf-fill', '#dc3545'];
        if ($ext === 'doc' || $ext === 'docx') return ['bi-file-earmark-word-fill', '#0d6efd'];
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) return ['bi-file-earmark-image-fill', '#198754'];
        return ['bi-file-earmark-fill', '#6c757d'];
    }
    function repo_size($b) {
        $b = (float)$b;
        if ($b <= 0) return '-';
        if ($b < 1024) return $b . ' B';
        if ($b < 1048576) return round($b / 1024, 1) . ' KB';
        return round($b / 1048576, 1) . ' MB';
    }
    function repo_name($n) {
        return preg_replace('/^\d+_/', '', $n);
    }
}

$departments = ['Computer Studies', 'HBM', 'BindTech', 'Education', 'Not Teaching', 'Others'];
$statuses = ['Pending', 'Approved', 'Rejected', 'Returned'];

$hasReturns = false;
$chk = mysqli_query($conn, "SHOW TABLES LIKE 'hr_returned_files'");
if ($chk && mysqli_num_rows($chk) > 0) { $hasReturns = true; }

$q      = mysqli_real_escape_string($conn, trim($_GET['q'] ?? ''));
$dept   = in_array($_GET['dept'] ?? '', $departments, true) ? $_GET['dept'] : '';
$cat    = (int)($_GET['cat'] ?? 0);
$status = in_array($_GET['status'] ?? '', $statuses, true) ? $_GET['status'] : '';
$type   = in_array($_GET['type'] ?? '', ['upload', 'hr'], true) ? $_GET['type'] : '';
$from   = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['from'] ?? '') ? $_GET['from'] : '';
$to     = preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['to'] ?? '') ? $_GET['to'] : '';
if ($type === 'hr' && !$hasReturns) { $type = ''; }

$union = "
SELECT 'upload' AS src, d.document_id, u.user_id, u.first_name, u.last_name, u.employee_id, u.department,
       d.category_id, c.category_name, d.document_title AS title, d.file_name, d.file_path, d.file_size,
       d.status, d.is_archived, d.submitted_at AS file_date, NULL AS note, NULL AS sent_by
FROM documents d
JOIN users u ON u.user_id = d.user_id
LEFT JOIN document_categories c ON c.category_id = d.category_id
";
if ($hasReturns) {
    $union .= "
UNION ALL
SELECT 'hr' AS src, d.document_id, u.user_id, u.first_name, u.last_name, u.employee_id, u.department,
       d.category_id, c.category_name, d.document_title AS title, r.file_name, r.file_path, r.file_size,
       d.status, d.is_archived, r.sent_at AS file_date, r.note, CONCAT(h.first_name, ' ', h.last_name) AS sent_by
FROM hr_returned_files r
JOIN documents d ON d.document_id = r.document_id
JOIN users u ON u.user_id = d.user_id
LEFT JOIN users h ON h.user_id = r.hr_user_id
LEFT JOIN document_categories c ON c.category_id = d.category_id
";
}

$w = [];
if ($q !== '') {
    $w[] = "(t.first_name LIKE '%$q%' OR t.last_name LIKE '%$q%' OR CONCAT(t.first_name,' ',t.last_name) LIKE '%$q%'
             OR t.employee_id LIKE '%$q%' OR t.title LIKE '%$q%' OR t.file_name LIKE '%$q%')";
}
if ($dept !== '')   { $w[] = "t.department = '" . mysqli_real_escape_string($conn, $dept) . "'"; }
if ($cat > 0)       { $w[] = "t.category_id = $cat"; }
if ($status !== '') { $w[] = "t.status = '" . mysqli_real_escape_string($conn, $status) . "'"; }
if ($type !== '')   { $w[] = "t.src = '$type'"; }
if ($from !== '')   { $w[] = "DATE(t.file_date) >= '$from'"; }
if ($to !== '')     { $w[] = "DATE(t.file_date) <= '$to'"; }
$where = $w ? ('WHERE ' . implode(' AND ', $w)) : '';

$stat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS n, COALESCE(SUM(t.file_size),0) AS s FROM ($union) t $where"));
$total = (int)$stat['n'];
$sumSize = (float)$stat['s'];

$perPage = 20;
$pages = max(1, (int)ceil($total / $perPage));
$page = min(max(1, (int)($_GET['page'] ?? 1)), $pages);
$offset = ($page - 1) * $perPage;

$rows = mysqli_query($conn, "SELECT t.* FROM ($union) t $where ORDER BY t.file_date DESC LIMIT $perPage OFFSET $offset");
$catList = mysqli_query($conn, "SELECT category_id, category_name FROM document_categories ORDER BY category_name");

$qs = $_GET; unset($qs['page']);
$qsBase = http_build_query($qs);
?>
<style>
.repo-stat{background:#fff;border-radius:12px;padding:12px 16px;box-shadow:0 4px 14px rgba(10,46,115,.08);}
.repo-stat small{color:#777;text-transform:uppercase;letter-spacing:.4px;font-size:.7rem;}
.repo-stat h4{margin:0;font-weight:700;color:#0A2E73;}
.repo-box{background:#fff;border-radius:12px;padding:16px;box-shadow:0 4px 14px rgba(10,46,115,.08);}
.repo-file{display:flex;align-items:center;gap:8px;}
.repo-file i{font-size:1.4rem;}
.repo-file .nm{font-weight:500;word-break:break-word;}
</style>

<div class="row g-3 mb-3">
    <div class="col-md-4"><div class="repo-stat"><small>Files found</small><h4><?php echo number_format($total); ?></h4></div></div>
    <div class="col-md-4"><div class="repo-stat"><small>Total size</small><h4><?php echo repo_size($sumSize); ?></h4></div></div>
    <div class="col-md-4"><div class="repo-stat"><small>Showing page</small><h4><?php echo $page; ?> / <?php echo $pages; ?></h4></div></div>
</div>

<div class="repo-box mb-3">
<form method="GET" action="<?php echo htmlspecialchars($repo_self); ?>">
<div class="row g-2">
    <div class="col-lg-4 col-md-6">
        <input type="text" name="q" class="form-control" placeholder="Search faculty, employee ID, document or file name"
               value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
    </div>
    <div class="col-lg-2 col-md-6">
        <select name="dept" class="form-select">
            <option value="">All Departments</option>
            <?php foreach ($departments as $d): ?>
            <option value="<?php echo htmlspecialchars($d); ?>" <?php echo $dept === $d ? 'selected' : ''; ?>><?php echo htmlspecialchars($d); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-lg-2 col-md-4">
        <select name="cat" class="form-select">
            <option value="0">All Categories</option>
            <?php while ($c = mysqli_fetch_assoc($catList)): ?>
            <option value="<?php echo (int)$c['category_id']; ?>" <?php echo $cat === (int)$c['category_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['category_name']); ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-lg-2 col-md-4">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            <?php foreach ($statuses as $s): ?>
            <option value="<?php echo $s; ?>" <?php echo $status === $s ? 'selected' : ''; ?>><?php echo $s; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-lg-2 col-md-4">
        <select name="type" class="form-select">
            <option value="">All Files</option>
            <option value="upload" <?php echo $type === 'upload' ? 'selected' : ''; ?>>Faculty uploads</option>
            <?php if ($hasReturns): ?>
            <option value="hr" <?php echo $type === 'hr' ? 'selected' : ''; ?>>Sent by HR</option>
            <?php endif; ?>
        </select>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="input-group">
            <span class="input-group-text">From</span>
            <input type="date" name="from" class="form-control" value="<?php echo htmlspecialchars($from); ?>">
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="input-group">
            <span class="input-group-text">To</span>
            <input type="date" name="to" class="form-control" value="<?php echo htmlspecialchars($to); ?>">
        </div>
    </div>
    <div class="col-lg-6 d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
        <a href="<?php echo htmlspecialchars($repo_self); ?>" class="btn btn-secondary">Reset</a>
    </div>
</div>
</form>
</div>

<div class="repo-box">
<div class="table-responsive">
<table class="table table-hover align-middle">
<thead>
<tr>
    <th>File</th>
    <th>Faculty</th>
    <th>Document / Category</th>
    <th>Status</th>
    <th>Date</th>
    <th style="width:130px;">Actions</th>
</tr>
</thead>
<tbody>
<?php if ($total === 0): ?>
<tr><td colspan="6" class="text-center text-muted py-4">No files found.</td></tr>
<?php endif; ?>
<?php while ($r = mysqli_fetch_assoc($rows)):
    $disp = repo_name($r['file_name']);
    [$ic, $icColor] = repo_icon($disp);
    $exists = file_exists(__DIR__ . '/' . $r['file_path']);
    $st = $r['status'];
    $cls = $st === 'Approved' ? 'bg-success' : ($st === 'Rejected' ? 'bg-danger' : ($st === 'Returned' ? 'bg-info text-dark' : 'bg-warning text-dark'));
?>
<tr>
    <td>
        <div class="repo-file">
            <i class="bi <?php echo $ic; ?>" style="color:<?php echo $icColor; ?>"></i>
            <div>
                <div class="nm"><?php echo htmlspecialchars($disp); ?></div>
                <small class="text-muted"><?php echo repo_size($r['file_size']); ?></small>
                <?php if ($r['src'] === 'hr'): ?>
                    <span class="badge bg-primary">Sent by HR</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Faculty upload</span>
                <?php endif; ?>
                <?php if ((int)$r['is_archived'] === 1): ?><span class="badge bg-dark">Archived</span><?php endif; ?>
                <?php if (!$exists): ?><span class="badge bg-danger">File missing</span><?php endif; ?>
            </div>
        </div>
    </td>
    <td>
        <a href="<?php echo htmlspecialchars($repo_profile_url . (int)$r['user_id']); ?>" class="fw-semibold text-decoration-none">
            <?php echo htmlspecialchars($r['first_name'] . ' ' . $r['last_name']); ?>
        </a><br>
        <small class="text-muted"><?php echo htmlspecialchars(($r['employee_id'] ?: '-') . ' · ' . ($r['department'] ?: '-')); ?></small>
    </td>
    <td>
        <?php echo htmlspecialchars($r['title']); ?><br>
        <small class="text-muted"><?php echo htmlspecialchars($r['category_name'] ?? '-'); ?></small>
        <?php if ($r['src'] === 'hr'): ?>
            <?php if (!empty($r['sent_by'])): ?><br><small class="text-muted">From: <?php echo htmlspecialchars($r['sent_by']); ?></small><?php endif; ?>
            <?php if (!empty($r['note'])): ?><br><small class="text-muted fst-italic">"<?php echo htmlspecialchars($r['note']); ?>"</small><?php endif; ?>
        <?php endif; ?>
    </td>
    <td><span class="badge <?php echo $cls; ?>"><?php echo htmlspecialchars($st); ?></span></td>
    <td><?php echo date('M d, Y', strtotime($r['file_date'])); ?><br><small class="text-muted"><?php echo date('h:i A', strtotime($r['file_date'])); ?></small></td>
    <td>
        <?php if ($exists): ?>
        <a href="<?php echo htmlspecialchars($r['file_path']); ?>" target="_blank" class="btn btn-sm btn-primary" title="View"><i class="bi bi-eye-fill"></i></a>
        <a href="<?php echo htmlspecialchars($r['file_path']); ?>" download="<?php echo htmlspecialchars($disp); ?>" class="btn btn-sm btn-secondary" title="Download"><i class="bi bi-download"></i></a>
        <?php else: ?>
        <span class="text-muted small">Unavailable</span>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<?php if ($pages > 1): ?>
<nav class="mt-3">
<ul class="pagination pagination-sm justify-content-center mb-0">
    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
        <a class="page-link" href="?<?php echo $qsBase . ($qsBase ? '&' : '') . 'page=' . ($page - 1); ?>">Prev</a>
    </li>
    <?php for ($i = max(1, $page - 2); $i <= min($pages, $page + 2); $i++): ?>
    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
        <a class="page-link" href="?<?php echo $qsBase . ($qsBase ? '&' : '') . 'page=' . $i; ?>"><?php echo $i; ?></a>
    </li>
    <?php endfor; ?>
    <li class="page-item <?php echo $page >= $pages ? 'disabled' : ''; ?>">
        <a class="page-link" href="?<?php echo $qsBase . ($qsBase ? '&' : '') . 'page=' . ($page + 1); ?>">Next</a>
    </li>
</ul>
</nav>
<?php endif; ?>
</div>