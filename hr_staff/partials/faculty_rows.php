<?php
// Expects $query (mysqli result) to already be set by the calling script.

if (mysqli_num_rows($query) === 0) {
?>
<tr>
    <td colspan="6" class="text-center text-muted py-4">No faculty found.</td>
</tr>
<?php
} else {
    while ($row = mysqli_fetch_assoc($query)) {
?>
<tr>
    <td><?php echo htmlspecialchars($row['employee_id']); ?></td>
    <td><strong><?php echo htmlspecialchars($row['first_name'].' '.$row['middle_name'].' '.$row['last_name']); ?></strong></td>
    <td><?php echo htmlspecialchars($row['email']); ?></td>
    <td><?php echo htmlspecialchars($row['department'] ?? ''); ?></td>
    <td>
        <?php if ($row['status'] === 'Active'): ?>
            <span class="badge bg-success">Active</span>
        <?php else: ?>
            <span class="badge bg-danger">Inactive</span>
        <?php endif; ?>
    </td>
    <td>
        <a href="faculty_profile.php?id=<?php echo $row['user_id']; ?>" class="btn btn-info btn-sm" title="View Profile">
            <i class="bi bi-person-vcard-fill"></i>
        </a>
    </td>
</tr>
<?php
    }
}
?>