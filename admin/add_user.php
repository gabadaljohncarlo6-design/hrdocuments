<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

if(isset($_POST['save']))
{

    $employee_id=mysqli_real_escape_string($conn,$_POST['employee_id']);
    $first_name=mysqli_real_escape_string($conn,$_POST['first_name']);
    $middle_name=mysqli_real_escape_string($conn,$_POST['middle_name']);
    $last_name=mysqli_real_escape_string($conn,$_POST['last_name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $role=mysqli_real_escape_string($conn,$_POST['role']);
    $department=mysqli_real_escape_string($conn,$_POST['department']);

    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);

/* Check Employee ID */

$checkEmployee=mysqli_query($conn,"
SELECT *
FROM users
WHERE employee_id='$employee_id'
");

if(mysqli_num_rows($checkEmployee)>0)
{
    $error="Employee ID already exists.";
}

/* Check Email */

elseif(mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM users
WHERE email='$email'
"))>0)
{
    $error="Email already exists.";
}

else
{

    mysqli_query($conn,"
    INSERT INTO users
    (
        employee_id,
        first_name,
        middle_name,
        last_name,
        email,
        password,
        role,
        department,
        status
    )
    VALUES
    (
        '$employee_id',
        '$first_name',
        '$middle_name',
        '$last_name',
        '$email',
        '$password',
        '$role',
        '$department',
        'Active'
    )
    ");

    $admin_id = (int)$_SESSION['user_id'];
    $newName = mysqli_real_escape_string($conn, $first_name.' '.$last_name);
    mysqli_query($conn, "
    INSERT INTO activity_logs (user_id, activity, module)
    VALUES ('$admin_id', 'Created new $role account: $newName', 'User Management')
    ");

    header("Location: users.php?success=1");
    exit();

}

}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add User</title>

<link rel="icon" href="../images/isatu_logo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
background:#eef3fb;
font-family:Poppins,sans-serif;
}

.card{
margin-top:40px;
border:none;
border-radius:18px;
box-shadow:0 10px 30px rgba(0,0,0,.08);
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card">

<div class="card-header bg-primary text-white">

<h3 class="mb-0">

<i class="bi bi-person-plus-fill"></i>

Add New User

</h3>

</div>

<div class="card-body">
<?php

if(isset($error))
{

echo "<div class='alert alert-danger'>$error</div>";

}

?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>Employee ID</label>

<input
type="text"
name="employee_id"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="col-md-4 mb-3">

<label>First Name</label>

<input
type="text"
name="first_name"
class="form-control"
required>

</div>

<div class="col-md-4 mb-3">

<label>Middle Name</label>

<input
type="text"
name="middle_name"
class="form-control">

</div>

<div class="col-md-4 mb-3">

<label>Last Name</label>

<input
type="text"
name="last_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Department</label>

<select
name="department"
class="form-select"
required>

<option value="" selected disabled>Select Department</option>
<option value="Computer Studies">Computer Studies</option>
<option value="HBM">HBM</option>
<option value="BindTech">BindTech</option>
<option value="Education">Education</option>
<option value="Not Teaching">Not Teaching</option>
<option value="Others">Others</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Role</label>

<select
name="role"
class="form-select"
required>

<option value="faculty">Faculty</option>

<option value="hr">HR Staff</option>

<option value="admin">Administrator</option>

</select>

</div>

<div class="text-end">

<a
href="users.php"
class="btn btn-secondary">

Cancel

</a>

<button
type="submit"
name="save"
class="btn btn-primary">

<i class="bi bi-check-circle-fill"></i>

Save User

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<script src="../assets/password-toggle.js"></script>
</body>

</html>