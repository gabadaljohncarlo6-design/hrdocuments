<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}

include "../db.php";
include "../includes/pdf_helper.php";

$result = mysqli_query($conn, "
SELECT
documents.document_title,
document_categories.category_name,
documents.status,
documents.submitted_at,
users.first_name,
users.last_name,
users.department
FROM documents
LEFT JOIN users
ON documents.user_id = users.user_id
LEFT JOIN document_categories
ON documents.category_id = document_categories.category_id
ORDER BY documents.submitted_at DESC
");

$settings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM system_settings LIMIT 1"));
$schoolName = $settings['school_name'] ?: 'Iloilo Science and Technology University';
$campus = $settings['campus'] ?: 'Miagao Campus';

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body{
font-family: Arial, sans-serif;
font-size: 12px;
color: #222;
}
.header{
text-align: center;
margin-bottom: 20px;
border-bottom: 3px solid #0A2E73;
padding-bottom: 12px;
}
.header h2{
color: #0A2E73;
margin: 0 0 4px 0;
font-size: 18px;
}
.header h4{
margin: 0;
font-size: 14px;
font-weight: normal;
color: #555;
}
.header p{
margin: 4px 0 0 0;
font-size: 11px;
color: #888;
}
table{
width: 100%;
border-collapse: collapse;
margin-top: 15px;
}
th, td{
border: 1px solid #ccc;
padding: 6px 8px;
text-align: left;
font-size: 11px;
}
th{
background: #0A2E73;
color: #fff;
}
tr:nth-child(even){
background: #f5f7fb;
}
.status{
font-weight: bold;
}
.status-Approved{ color: #1a7a3c; }
.status-Pending{ color: #a67c00; }
.status-Rejected{ color: #a71d2a; }
.status-Returned{ color: #0d6efd; }
.footer{
margin-top: 25px;
font-size: 10px;
color: #888;
text-align: center;
}
</style>
</head>
<body>

<div class="header">
<h2><?php echo htmlspecialchars($schoolName); ?></h2>
<h4><?php echo htmlspecialchars($campus); ?> — HR Document Management System</h4>
<p>Documents Report — Generated <?php echo date("F d, Y g:i A"); ?></p>
</div>

<table>
<thead>
<tr>
<th>#</th>
<th>Faculty</th>
<th>Department</th>
<th>Document</th>
<th>Category</th>
<th>Status</th>
<th>Submitted</th>
</tr>
</thead>
<tbody>
<?php
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo htmlspecialchars($row['first_name'].' '.$row['last_name']); ?></td>
<td><?php echo htmlspecialchars($row['department']); ?></td>
<td><?php echo htmlspecialchars($row['document_title']); ?></td>
<td><?php echo htmlspecialchars($row['category_name']); ?></td>
<td class="status status-<?php echo htmlspecialchars($row['status']); ?>"><?php echo htmlspecialchars($row['status']); ?></td>
<td><?php echo date("F d, Y", strtotime($row['submitted_at'])); ?></td>
</tr>
<?php } ?>
</tbody>
</table>

<div class="footer">
This is a system-generated report from the ISAT U HR Document Management System.
</div>

</body>
</html>
<?php
$html = ob_get_clean();

generate_pdf($html, "documents_report_" . date("Y-m-d") . ".pdf");