<?php

include 'db.php';

$message = "";

if (isset($_POST['register'])) {

    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $first_name  = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name   = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email       = mysqli_real_escape_string($conn, $_POST['email']);
    $department  = mysqli_real_escape_string($conn, $_POST['department']);

    $allowed_departments = ['Computer Studies','HBM','BindTech','Education','Not Teaching','Others'];
    if (!in_array($_POST['department'], $allowed_departments)) {
        $department = 'Others';
    }

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $authCheck = mysqli_query($conn, "
        SELECT *
        FROM authorized_employee_ids
        WHERE employee_id = '$employee_id'
    ");
    $authRow = mysqli_num_rows($authCheck) > 0 ? mysqli_fetch_assoc($authCheck) : null;

    if (!$authRow) {

        $message = "<div class='alert alert-danger'>
            This Employee ID has not been authorized for registration.
            Please contact the HR/Admin office to have your Employee ID added first.
        </div>";

    } elseif ((int)$authRow['is_claimed'] === 1) {

        $message = "<div class='alert alert-danger'>
            This Employee ID has already been used to register an account.
            If this is you, please log in instead. If not, contact the HR/Admin office.
        </div>";

    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $_POST['email'])) {

        $message = "<div class='alert alert-danger'>
            Please use a valid Gmail address (must end in @gmail.com).
        </div>";

    } else {

    $checkEmployee = mysqli_query($conn, "
        SELECT *
        FROM users
        WHERE employee_id = '$employee_id'
    ");

    if (mysqli_num_rows($checkEmployee) > 0) {

        $message = "<div class='alert alert-danger'>
            Employee ID already exists.
        </div>";

    } else {

        $checkEmail = mysqli_query($conn, "
            SELECT *
            FROM users
            WHERE email = '$email'
        ");

        if (mysqli_num_rows($checkEmail) > 0) {

            $message = "<div class='alert alert-danger'>
                Email already exists.
            </div>";

        } else {

            mysqli_query($conn, "
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
                    'faculty',
                    '$department',
                    'Active'
                )
            ");

            $new_user_id = mysqli_insert_id($conn);
            $ip = mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR'] ?? 'unknown');
            mysqli_query($conn, "
            INSERT INTO activity_logs (user_id, activity, module, ip_address)
            VALUES ('$new_user_id', 'New faculty account registered', 'Authentication', '$ip')
            ");

            mysqli_query($conn, "
            UPDATE authorized_employee_ids
            SET is_claimed = 1, claimed_at = NOW()
            WHERE employee_id = '$employee_id'
            ");

            $message = "<div class='alert alert-success'>
                Registration Successful! You may now login.
            </div>";

        }
    }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Faculty Registration</title>

    <link rel="icon" href="images/isatu_logo.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            overflow-y: auto;
            background: url("images/isatu_building.jfif");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(7, 33, 86, .75), rgba(7, 33, 86, .75));
        }

        .container-register {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .left-content {
            color: #fff;
            padding-left: 130px;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .left-content h1 {
            font-size: 58px;
            font-weight: 700;
            line-height: 1.2;
        }

        .left-content h2 {
            font-size: 30px;
            font-weight: 300;
            margin-top: 12px;
        }

        .left-content p {
            margin-top: 25px;
            font-size: 18px;
            line-height: 32px;
            opacity: .95;
        }

        .register-card {
            width: 520px;
            background: rgba(255, 255, 255, .96);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .30);
            backdrop-filter: blur(15px);
        }

        .logo {
            width: 110px;
            display: block;
            margin: auto;
            margin-bottom: 15px;
        }

        .register-card h3 {
            text-align: center;
            font-weight: 700;
            color: #0A2E73;
            margin-bottom: 5px;
        }

        .register-card h6 {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-weight: 400;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            height: 55px;
            border-radius: 12px;
        }

        .form-control:focus {
            border-color: #0A2E73;
            box-shadow: 0 0 10px rgba(10, 46, 115, .20);
        }

        .btn-register {
            height: 55px;
            background: #0A2E73;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 17px;
            transition: .3s;
        }

        .btn-register:hover {
            background: #F5B400;
            color: #000;
            transform: translateY(-2px);
        }

        .login-link {
            text-decoration: none;
            font-weight: 600;
            color: #0A2E73;
        }

        .login-link:hover {
            color: #F5B400;
        }

        .footer-text {
            margin-top: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }

        @media (max-width: 991px) {

            body {
                overflow: auto;
            }

            .left-content {
                display: none;
            }

            .container-register {
                height: auto;
                padding: 40px 15px;
            }

            .register-card {
                width: 100%;
                max-width: 520px;
            }

        }

    </style>

<link rel="stylesheet" href="assets/auth.css">
</head>
<body>

    <div class="overlay"></div>

    <div class="container container-register">
        <div class="row align-items-center w-100">

            <!-- LEFT SIDE -->
            <div class="col-lg-5">
                <div class="register-card">

                    <img src="images/isatu_logo.png" class="logo">

                    <h3>Faculty Registration</h3>
                    <h6>ISAT U Miagao Campus</h6>

                    <?php echo $message; ?>

                    <form method="POST">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Employee ID</label>
                                <input
                                    type="text"
                                    name="employee_id"
                                    class="form-control"
                                    placeholder="Employee ID"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <select name="department" class="form-select" required>
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
                                <label class="form-label">First Name</label>
                                <input
                                    type="text"
                                    name="first_name"
                                    class="form-control"
                                    placeholder="First Name"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Middle Name</label>
                                <input
                                    type="text"
                                    name="middle_name"
                                    class="form-control"
                                    placeholder="Middle Name">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Last Name</label>
                                <input
                                    type="text"
                                    name="last_name"
                                    class="form-control"
                                    placeholder="Last Name"
                                    required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Gmail Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Enter your Gmail address"
                                    pattern="[a-zA-Z0-9._%+-]+@gmail\.com"
                                    title="Please enter a valid Gmail address (must end in @gmail.com)"
                                    required>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Create Password"
                                    required>
                            </div>

                        </div>

                        <button type="submit" name="register" class="btn btn-register w-100">
                            <i class="bi bi-person-plus-fill"></i>
                            Create Faculty Account
                        </button>

                        <div class="text-center mt-4">
                            Already have an account?
                            <br>
                            <a href="login.php" class="login-link">Login Here</a>
                        </div>

                        <div class="footer-text">
                            &copy; <?php echo date("Y"); ?>
                            Iloilo Science and Technology University
                            <br>
                            Miagao Campus
                        </div>

                    </form>

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-7">
                <div class="left-content">
                    <h1>Join the</h1>
                    <h2>ISAT U HR Document Management System</h2>
                    <p>
                        Create your faculty account to securely submit and monitor Human Resource documents online.
                        <br><br>
                        <strong>
                            Iloilo Science and Technology University
                            <br>
                            Miagao Campus
                        </strong>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/password-toggle.js"></script>
</body>
</html>