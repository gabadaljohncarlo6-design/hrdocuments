<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

if(!isset($_GET['id']))
{
    header("Location: users.php");
    exit();
}

$user_id = $_GET['id'];

$query = mysqli_query($conn,"
SELECT *
FROM users
WHERE user_id='$user_id'
");

$user = mysqli_fetch_assoc($query);

if(!$user)
{
    header("Location: users.php");
    exit();
}

if(isset($_POST['update']))
{
    $employee_id = mysqli_real_escape_string($conn,$_POST['employee_id']);
    $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn,$_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $department = mysqli_real_escape_string($conn,$_POST['department']);
    $position_title = mysqli_real_escape_string($conn,$_POST['position_title']);
    $role = mysqli_real_escape_string($conn,$_POST['role']);
    $status = mysqli_real_escape_string($conn,$_POST['status']);

    mysqli_query($conn,"
    UPDATE users
    SET
        employee_id='$employee_id',
        first_name='$first_name',
        middle_name='$middle_name',
        last_name='$last_name',
        email='$email',
        department='$department',
        position_title='$position_title',
        role='$role',
        status='$status'
    WHERE user_id='$user_id'
    ");

    $admin_id = (int)$_SESSION['user_id'];
    mysqli_query($conn, "
    INSERT INTO activity_logs (user_id, activity, module)
    VALUES ('$admin_id', 'Updated user: $first_name $last_name', 'User Management')
    ");

    $success = "User updated successfully.";

    $query = mysqli_query($conn,"
    SELECT *
    FROM users
    WHERE user_id='$user_id'
    ");

    $user = mysqli_fetch_assoc($query);
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Edit User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">

<div class="container-fluid">

<span class="navbar-brand">
Edit User
</span>

<div>

<a href="users.php" class="btn btn-primary">
Back
</a>

<a href="../logout.php" onclick="return confirm('Are you sure you want to log out?')" class="btn btn-danger">
Logout
</a>

</div>

</div>

</nav>

<div class="container mt-4">

<div class="card shadow">

<div class="card-header bg-warning">

<h4>Edit User Information</h4>

</div>

<div class="card-body">

<?php
if(isset($success))
{
?>
<div class="alert alert-success">
<?php echo $success; ?>
</div>
<?php
}
?>

<form method="POST">

<div class="row">

<div class="col-md-6">

<label class="form-label">
Employee ID
</label>

<input
type="text"
name="employee_id"
class="form-control"
value="<?php echo $user['employee_id']; ?>">

</div>

<div class="col-md-6">

<label class="form-label">
Email
</label>

<input
type="email"
name="email"
class="form-control"
value="<?php echo $user['email']; ?>">

</div>

</div>

<div class="row mt-3">

<div class="col-md-4">

<label class="form-label">
First Name
</label>

<input
type="text"
name="first_name"
class="form-control"
value="<?php echo $user['first_name']; ?>">
</div>

<div class="col-md-4">

<label class="form-label">
Middle Name
</label>

<input
type="text"
name="middle_name"
class="form-control"
value="<?php echo $user['middle_name']; ?>">

</div>

<div class="col-md-4">

<label class="form-label">
Last Name
</label>

<input
type="text"
name="last_name"
class="form-control"
value="<?php echo $user['last_name']; ?>">

</div>

</div>

<div class="row mt-3">

<div class="col-md-6">

<label class="form-label">
Department
</label>

<?php $depts = ['Computer Studies','HBM','BindTech','Education','Not Teaching','Others']; ?>
<select name="department" class="form-select">
<option value="" disabled <?php echo empty($user['department']) ? 'selected' : ''; ?>>Select Department</option>
<?php foreach ($depts as $d): ?>
<option value="<?php echo $d; ?>" <?php echo ($user['department'] === $d) ? 'selected' : ''; ?>><?php echo $d; ?></option>
<?php endforeach; ?>
</select>

</div>

<div class="col-md-6">

<label class="form-label">
Position Title
</label>

<input
type="text"
name="position_title"
class="form-control"
value="<?php echo $user['position_title']; ?>">

</div>

</div>

<div class="row mt-3">

<div class="col-md-6">

<label class="form-label">
Role
</label>

<select
name="role"
class="form-control">

<option value="faculty" <?php if($user['role']=="faculty") echo "selected"; ?>>
Faculty
</option>

<option value="hr" <?php if($user['role']=="hr") echo "selected"; ?>>
HR
</option>

<option value="admin" <?php if($user['role']=="admin") echo "selected"; ?>>
Admin
</option>

</select>

</div>

<div class="col-md-6">

<label class="form-label">
Status
</label>

<select
name="status"
class="form-control">

<option value="active" <?php if($user['status']=="active") echo "selected"; ?>>
Active
</option>

<option value="inactive" <?php if($user['status']=="inactive") echo "selected"; ?>>
Inactive
</option>

</select>

</div>

</div>

<div class="mt-4">

<button
type="submit"
name="update"
class="btn btn-success">

Update User

</button>

<a
href="users.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>