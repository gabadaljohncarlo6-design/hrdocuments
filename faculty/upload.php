<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$message="";

if(isset($_POST['upload']))
{
    $user_id=$_SESSION['user_id'];
    $category_id=$_POST['category_id'];

    $document_title=mysqli_real_escape_string(
    $conn,
    $_POST['document_title']
    );
    $faculty_comment = mysqli_real_escape_string($conn, $_POST['faculty_comment']);

    $filename=$_FILES['document']['name'];
    $tmpname=$_FILES['document']['tmp_name'];

    $extension=strtolower(pathinfo($filename,PATHINFO_EXTENSION));

    $allowed=array(
    "pdf",
    "doc",
    "docx",
    "jpg",
    "jpeg",
    "png"
    );

    if(in_array($extension,$allowed))
    {
        $newname=time()."_".$filename;

        $upload_path="../uploads/".$newname;
        $file_size=$_FILES['document']['size'];

        // If there's an active, not-yet-expired deadline for this document
        // type, link this submission to it so HR's "who submitted" tracker
        // and reminders pick it up correctly.
        $deadline_id = "NULL";
        $deadlineRow = mysqli_fetch_assoc(mysqli_query($conn, "
            SELECT deadline_id FROM submission_deadlines
            WHERE category_id = '$category_id'
              AND status = 'Active'
            ORDER BY created_at DESC
            LIMIT 1
        "));
        if ($deadlineRow) {
            $deadline_id = (int)$deadlineRow['deadline_id'];
        }

        if(move_uploaded_file($tmpname,$upload_path))
        {
            mysqli_query($conn,"
            INSERT INTO documents
            (
            user_id,
            category_id,
            document_title,
            faculty_comment,
            file_name,
            file_path,
            file_size,
            deadline_id,
            status
            )
            VALUES
            (
            '$user_id',
            '$category_id',
            '$document_title',
            '$faculty_comment',
            '$newname',
            '$upload_path',
            '$file_size',
            $deadline_id,
            'Pending'
            )
            ");

            $message="
            <div class='alert alert-success'>
            Document uploaded successfully.
            </div>";
        }
        else
        {
            $message="
            <div class='alert alert-danger'>
            Upload failed.
            </div>";
        }
    }
    else
    {
        $message="
        <div class='alert alert-danger'>
        Invalid file type.
        </div>";
    }
}

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Upload Document</title>

<link rel="icon" href="../images/isatu_logo.png">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#eef3fb;
}

.container-box{
max-width:900px;
margin:50px auto;
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

.form-control,
.form-select{
border-radius:10px;
padding:12px;
}

.btn{
padding:10px 25px;
border-radius:10px;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="container-box">

<div class="card">

<div class="card-header">

<h3 class="mb-0">

<i class="bi bi-cloud-upload-fill"></i>

Upload HR Document

</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">

<label class="form-label">

Document Category

</label>

<select
name="category_id"
class="form-select"
required>

<option value="">

Select Category

</option>

<?php

$categories=mysqli_query($conn,"
SELECT *
FROM document_categories
ORDER BY category_name ASC
");

while($row=mysqli_fetch_assoc($categories))
{

?>

<option value="<?php echo $row['category_id']; ?>">

<?php echo htmlspecialchars($row['category_name']); ?>

</option>

<?php

}

?>

</select>

</div>

<div class="mb-3">

<label class="form-label">

Document Title

</label>

<input
type="text"
name="document_title"
class="form-control"
placeholder="Enter document title"
required>

</div>
<div class="mb-3">
    <label class="form-label">Comment to HR (Optional)</label>

    <textarea
        name="faculty_comment"
        class="form-control"
        rows="4"
        placeholder="Write a message for HR about this document..."></textarea>
</div>
<div class="mb-3">

<label class="form-label">

Choose File

</label>

<input
type="file"
name="document"
class="form-control"
accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
required>

<div class="form-text">

Allowed file types:
<strong>PDF, DOC, DOCX, JPG, JPEG, PNG</strong>

</div>

</div>

<div class="d-flex gap-2">

<button
type="submit"
name="upload"
class="btn btn-success">

<i class="bi bi-cloud-upload-fill"></i>

Upload Document

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