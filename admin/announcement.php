<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
include "../includes/mailer.php";
include "includes/header.php";
include "includes/sidebar.php";

if(isset($_POST['save']))
{
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $message=mysqli_real_escape_string($conn,$_POST['message']);

    mysqli_query($conn,"
    INSERT INTO announcements(title,message)
    VALUES('$title','$message')
    ");

    // Notify every active user (Faculty and HR) in-app + email
    $recipients = [];
    $userIds = [];

    $allUsers = mysqli_query($conn, "
        SELECT user_id, first_name, last_name, email
        FROM users
        WHERE status = 'Active' AND role IN ('faculty','hr')
    ");

    $notifMessage = mysqli_real_escape_string($conn, "New Announcement: " . $_POST['title']);

    while ($u = mysqli_fetch_assoc($allUsers)) {
        mysqli_query($conn, "
        INSERT INTO notifications (user_id, message, type)
        VALUES ('{$u['user_id']}', '$notifMessage', 'announcement')
        ");

        $recipients[] = ['email' => $u['email'], 'name' => $u['first_name'].' '.$u['last_name']];
    }

    if (!empty($recipients)) {
        $emailBody = "
            <p>Hello,</p>
            <p>A new announcement has been posted by the HR Office:</p>
            <h3 style='color:#0A2E73;'>" . htmlspecialchars($_POST['title']) . "</h3>
            <p>" . nl2br(htmlspecialchars($_POST['message'])) . "</p>
            <p>— ISAT U HR Office</p>
        ";

        send_bulk_notification_email(
            $conn,
            $recipients,
            "Announcement: " . $_POST['title'],
            $emailBody
        );
    }

    $admin_id = (int)$_SESSION['user_id'];
    mysqli_query($conn, "
    INSERT INTO activity_logs (user_id, activity, module)
    VALUES ('$admin_id', 'Posted announcement: " . mysqli_real_escape_string($conn, $_POST['title']) . "', 'Announcements')
    ");

    echo "<script>
    alert('Announcement posted successfully and sent to all faculty and HR staff.');
    window.location='announcement.php';
    </script>";
}

$result=mysqli_query($conn,"
SELECT *
FROM announcements
ORDER BY created_at DESC
");

?>

<div class="container-fluid">

<h2 class="fw-bold mb-4">

Announcements

</h2>

<div class="card shadow border-0 mb-4">

<div class="card-header bg-primary text-white">

<h5 class="mb-0">

Create Announcement

</h5>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Title</label>

<input
type="text"
name="title"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Message</label>

<textarea
name="message"
class="form-control"
rows="5"
required></textarea>

</div>

<button
type="submit"
name="save"
class="btn btn-success">

Post Announcement

</button>

</form>

</div>

</div>

<div class="card shadow border-0">

<div class="card-header bg-dark text-white">

<h5 class="mb-0">

Announcement History

</h5>

</div>

<div class="card-body">

<table class="table table-hover">

<thead>

<tr>

<th>#</th>

<th>Title</th>

<th>Message</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php

$i=1;

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $i++; ?></td>

<td><?php echo htmlspecialchars($row['title']); ?></td>

<td><?php echo htmlspecialchars($row['message']); ?></td>

<td><?php echo date("F d, Y h:i A",strtotime($row['created_at'])); ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>