<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$user_id=$_SESSION['user_id'];

if(isset($_POST['update']))
{
    $first_name=mysqli_real_escape_string($conn,$_POST['first_name']);
    $last_name=mysqli_real_escape_string($conn,$_POST['last_name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);

    mysqli_query($conn,"
    UPDATE users
    SET
    first_name='$first_name',
    last_name='$last_name',
    email='$email'
    WHERE user_id='$user_id'
    ");

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

    $_SESSION['fullname']=$first_name." ".$last_name;

    header("Location: profile.php?updated=1");
    exit();
}

$user=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT *
FROM users
WHERE user_id='$user_id'
"));

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile</title>

<link rel="icon" href="../images/isatu_logo.png">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
background:#eef3fb;
font-family:'Poppins',sans-serif;
}

.container-box{
max-width:700px;
margin:40px auto;
}

.card{
border:none;
border-radius:18px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.card-header{
background:#0A2E73;
color:#fff;
padding:20px;
border-radius:18px 18px 0 0 !important;
}

.card-body{
padding:35px;
}

.form-control{
border-radius:10px;
padding:12px;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="container-box">

<div class="card">

<div class="card-header">

<h3 class="mb-0">

<i class="bi bi-person-circle"></i>

My Profile

</h3>

</div>

<div class="card-body">

<?php if(isset($_GET['updated'])){ ?>

<div class="alert alert-success">

Profile updated successfully.

</div>

<?php } ?>

<form method="POST" enctype="multipart/form-data">

<div class="text-center mb-4">

<?php if (!empty($user['profile_picture']) && file_exists('../uploads/profile_pictures/'.$user['profile_picture'])): ?>
    <img src="../uploads/profile_pictures/<?php echo htmlspecialchars($user['profile_picture']); ?>"
         style="width:110px;height:110px;border-radius:50%;object-fit:cover;border:4px solid #0A2E73;">
<?php else: ?>
    <div style="width:110px;height:110px;border-radius:50%;background:#0A2E73;color:#fff;display:flex;align-items:center;justify-content:center;font-size:40px;font-weight:700;margin:auto;">
        <?php echo strtoupper(substr($user['first_name'],0,1)); ?>
    </div>
<?php endif; ?>

<div class="mt-3">
<label class="form-label d-block">Change Profile Picture</label>
<input type="file" name="profile_picture" class="form-control" accept=".jpg,.jpeg,.png" style="max-width:300px;margin:auto;">
</div>

</div>

<div class="mb-3">

<label class="form-label">

First Name

</label>

<input
type="text"
name="first_name"
class="form-control"
value="<?php echo htmlspecialchars($user['first_name']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Last Name

</label>

<input
type="text"
name="last_name"
class="form-control"
value="<?php echo htmlspecialchars($user['last_name']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Email Address

</label>

<input
type="email"
name="email"
class="form-control"
value="<?php echo htmlspecialchars($user['email']); ?>"
required>

</div>

<div class="mb-4">

<label class="form-label">

Role

</label>

<input
type="text"
class="form-control"
value="<?php echo htmlspecialchars(ucfirst($user['role'])); ?>"
readonly>

</div>

<div class="d-flex gap-2">

<button
type="submit"
name="update"
class="btn btn-success">

<i class="bi bi-check-circle-fill"></i>

Save Changes

</button>

<a
href="dashboard.php"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back to Dashboard

</a>

</div>

</form>

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>