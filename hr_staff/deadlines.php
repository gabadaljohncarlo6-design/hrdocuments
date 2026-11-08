<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
$hasReturns = false;
$chkR = mysqli_query($conn,"SHOW TABLES LIKE 'hr_returned_files'");
if($chkR && mysqli_num_rows($chkR) > 0) { $hasReturns = true; }

$user_id=$_SESSION['user_id'];

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Documents</title>

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
max-width:1200px;
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
display:flex;
justify-content:space-between;
align-items:center;
}

.form-control{
width:260px;
}

.table td,
.table th{
vertical-align:middle;
}

</style>

<link rel="stylesheet" href="../assets/ui.css">
</head>

<body>

<div class="container-box">

<div class="card">

<div class="card-header">

<h4 class="mb-0">

<i class="bi bi-folder-fill"></i>

My Documents

</h4>

<input
type="text"
id="searchInput"
class="form-control"
placeholder="Search document">

</div>

<div class="card-body">

<div class="mb-3">

<a href="dashboard.php" class="btn btn-secondary">
<i class="bi bi-arrow-left"></i>
Dashboard
</a>

<a href="upload.php" class="btn btn-success">
<i class="bi bi-cloud-upload-fill"></i>
Upload New
</a>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle" id="documentsTable">

<thead>

<tr>

<th>ID</th>

<th>Category</th>

<th>Title</th>

<th>File</th>

<th>Faculty Comment</th>

<th>Status</th>

<th>HR Remarks</th>
<th>File from HR</th>

<th>Date Submitted</th>

</tr>

</thead>

<tbody>
<?php

$query=mysqli_query($conn,"
SELECT
documents.*,
document_categories.category_name
FROM documents
LEFT JOIN document_categories
ON documents.category_id=document_categories.category_id
WHERE documents.user_id='$user_id'
ORDER BY documents.document_id DESC
");

while($row=mysqli_fetch_assoc($query))
{

?>

<tr>

<td><?php echo $row['document_id']; ?></td>

<td><?php echo htmlspecialchars($row['category_name']); ?></td>

<td><?php echo htmlspecialchars($row['document_title']); ?></td>
<td>

<?php

if(!empty($row['faculty_comment']))
{

    echo nl2br(htmlspecialchars($row['faculty_comment']));

}
else
{

    echo "<span class='text-muted'>No Comment</span>";

}

?>

</td>

<td>

<a
href="<?php echo $row['file_path']; ?>"
target="_blank"
class="btn btn-primary btn-sm">

<i class="bi bi-eye-fill"></i>

View

</a>

<a
href="<?php echo $row['file_path']; ?>"
download
class="btn btn-success btn-sm">

<i class="bi bi-download"></i>

Download

</a>

</td>

<td>

<?php

if($row['status']=="Approved")
{
    echo "<span class='badge bg-success'>Approved</span>";
}
elseif($row['status']=="Rejected")
{
    echo "<span class='badge bg-danger'>Rejected</span>";
}
elseif($row['status']=="Returned")
{
    echo "<span class='badge bg-warning text-dark'>Returned</span>";
}
else
{
    echo "<span class='badge bg-secondary'>Pending</span>";
}

?>

</td>

<td>

<?php echo htmlspecialchars($row['hr_remarks']); ?>

</td>
<td>
<?php
if($hasReturns)
{
    $rid=(int)$row['document_id'];
    $rf=mysqli_query($conn,"SELECT * FROM hr_returned_files WHERE document_id='$rid' ORDER BY return_id DESC");
    if($rf && mysqli_num_rows($rf)>0)
    {
        while($f=mysqli_fetch_assoc($rf))
        {
            echo "<div class='mb-2'>";
            echo "<a href='".htmlspecialchars($f['file_path'])."' download='".htmlspecialchars($f['file_name'])."' class='btn btn-sm btn-primary'><i class='bi bi-download'></i> ".htmlspecialchars($f['file_name'])."</a>";
            echo "<br><small class='text-muted'>".date('M d, Y',strtotime($f['sent_at']))."</small>";
            if(!empty($f['note'])) echo "<br><small class='fst-italic'>\"".htmlspecialchars($f['note'])."\"</small>";
            echo "</div>";
        }
    }
    else { echo "<span class='text-muted'>-</span>"; }
}
else { echo "<span class='text-muted'>-</span>"; }
?>
</td>

<td>

<?php echo date("F d, Y",strtotime($row['submitted_at'])); ?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>
</tbody>

</table>

</div>

</div>

</div>

<script>

document.getElementById("searchInput").addEventListener("keyup",function(){

let filter=this.value.toLowerCase();

let rows=document.querySelectorAll("#documentsTable tbody tr");

rows.forEach(function(row){

let text=row.innerText.toLowerCase();

row.style.display=text.includes(filter) ? "" : "none";

});

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>