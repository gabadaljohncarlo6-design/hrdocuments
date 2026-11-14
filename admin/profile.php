<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$user_id=$_SESSION['user_id'];

$query=mysqli_query($conn,"
SELECT *
FROM users
WHERE user_id='$user_id'
");

$row=mysqli_fetch_assoc($query);

$message="";

if(isset($_POST['update']))
{

    $first_name=mysqli_real_escape_string($conn,$_POST['first_name']);
    $middle_name=mysqli_real_escape_string($conn,$_POST['middle_name']);
    $last_name=mysqli_real_escape_string($conn,$_POST['last_name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $department=mysqli_real_escape_string($conn,$_POST['department']);

    mysqli_query($conn,"
    UPDATE users
    SET
    first_name='$first_name',
    middle_name='$middle_name',
    last_name='$last_name',
    email='$email',
    department='$department'
    WHERE user_id='$user_id'
    ");

    if(!empty($_POST['password']))
    {
        $password=password_hash($_POST['password'],PASSWORD_DEFAULT);

        mysqli_query($conn,"
        UPDATE users
        SET password='$password'
        WHERE user_id='$user_id'
        ");

        mysqli_query($conn, "
        INSERT INTO activity_logs (user_id, activity, module)
        VALUES ('$user_id', 'Changed own password', 'Authentication')
        ");
    }

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png'];

        if (in_array($ext, $allowed)) {
            $uploadDir = '../uploads/profile_pictures/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $newName = 'profile_' . $user_id . '_' . time() . '.' . $ext;

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadDir . $newName)) {
                mysqli_query($conn, "UPDATE users SET profile_picture='$newName' WHERE user_id='$user_id'");
            }
        }
    }

    echo "<script>
    alert('Profile Updated Successfully');
    window.location='profile.php';
    </script>";

    exit();

}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Administrator Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
background:#eef3fb;
font-family:Poppins,sans-serif;
}

.card{
border:none;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.profile-img{
width:120px;
height:120px;
border-radius:50%;
border:4px solid #0A2E73;
object-fit:cover;
}

.btn-save{
background:#0A2E73;
color:white;
}

.btn-save:hover{
background:#F5B400;
color:black;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card p-4">

<div class="text-center">

<?php if (!empty($row['profile_picture']) && file_exists('../uploads/profile_pictures/'.$row['profile_picture'])): ?>
    <img src="../uploads/profile_pictures/<?php echo htmlspecialchars($row['profile_picture']); ?>" class="profile-img">
<?php else: ?>
    <img src="../images/isatu_logo.png" class="profile-img">
<?php endif; ?>

<h3 class="mt-3">

<?php
echo $row['first_name']." ".$row['last_name'];
?>

</h3>

<p class="text-muted">

Administrator

</p>

</div>

<hr>

<form method="POST" enctype="multipart/form-data">

<div class="mb-4 text-center">
<label class="form-label d-block">Change Profile Picture</label>
<input type="file" name="profile_picture" class="form-control" accept=".jpg,.jpeg,.png" style="max-width:320px;margin:auto;">
</div>

<div class="row">

<div class="col-md-6 mb-3">

<label>Employee ID</label>

<input
type="text"
class="form-control"
value="<?php echo $row['employee_id']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>Department</label>

<input
type="text"
name="department"
class="form-control"
value="<?php echo $row['department']; ?>">

</div>

<div class="col-md-4 mb-3">

<label>First Name</label>

<input
type="text"
name="first_name"
class="form-control"
value="<?php echo $row['first_name']; ?>">

</div>

<div class="col-md-4 mb-3">

<label>Middle Name</label>

<input
type="text"
name="middle_name"
class="form-control"
value="<?php echo $row['middle_name']; ?>">

</div>

<div class="col-md-4 mb-3">

<label>Last Name</label>

<input
type="text"
name="last_name"
class="form-control"
value="<?php echo $row['last_name']; ?>">

</div>

<div class="col-12 mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="<?php echo $row['email']; ?>">

</div>

<div class="col-12 mb-4">

<label>New Password</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Leave blank if no changes">

</div>

</div>

<button
type="submit"
name="update"
class="btn btn-save w-100">

<i class="bi bi-check-circle-fill"></i>

Save Changes

</button>

</form>

</div>

</div>

</div>

</div>

<script src="../assets/password-toggle.js"></script>
</body>

</html>