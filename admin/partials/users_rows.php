<?php
// Expects $query (mysqli result) to already be set by the calling script.

if (mysqli_num_rows($query) === 0) {
?>
<tr>
    <td colspan="7" class="text-center text-muted py-4">
        No users found.
    </td>
</tr>
<?php
} else {
    while($row=mysqli_fetch_assoc($query))
    {
?>

<tr>

<td>

<?php echo htmlspecialchars($row['employee_id']); ?>

</td>

<td>

<strong>

<?php

echo htmlspecialchars(

$row['first_name']." ".
$row['middle_name']." ".
$row['last_name']

);

?>

</strong>

</td>

<td>

<?php echo htmlspecialchars($row['email']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['department'] ?? ''); ?>

</td>

<td>

<?php echo ucfirst($row['role']); ?>

</td>

<td>

<?php

if($row['status']=="Active")
{
echo "<span class='badge bg-success'>Active</span>";
}
else
{
echo "<span class='badge bg-danger'>Inactive</span>";
}

?>

</td>

<td>

<a
href="faculty_profile.php?id=<?php echo $row['user_id']; ?>"
class="btn btn-info btn-sm btn-action"
title="View Profile">

<i class="bi bi-person-vcard-fill"></i>

</a>

<a
href="edit_user.php?id=<?php echo $row['user_id']; ?>"
class="btn btn-warning btn-sm btn-action"
title="Edit">

<i class="bi bi-pencil-square"></i>

</a>

<button
type="button"
class="btn btn-sm btn-action <?php echo $row['status']=='Active' ? 'btn-outline-secondary' : 'btn-outline-success'; ?>"
title="<?php echo $row['status']=='Active' ? 'Deactivate' : 'Activate'; ?>"
onclick="toggleStatus(<?php echo $row['user_id']; ?>, '<?php echo $row['status']; ?>')">

<i class="bi <?php echo $row['status']=='Active' ? 'bi-slash-circle' : 'bi-check-circle'; ?>"></i>

</button>

<a
href="delete_user.php?id=<?php echo $row['user_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this user?')"
title="Delete">

<i class="bi bi-trash-fill"></i>

</a>

<?php if ($row['status'] === 'Inactive'): ?>
<a
href="delete_user_permanent.php?id=<?php echo $row['user_id']; ?>"
class="btn btn-dark btn-sm"
onclick="return confirm('PERMANENTLY delete this account? This will also delete all of their uploaded documents. This CANNOT be undone. Are you absolutely sure?')"
title="Delete Permanently">

<i class="bi bi-x-octagon-fill"></i>

</a>
<?php endif; ?>

</td>

</tr>

<?php
    }
}
?>