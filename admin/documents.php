<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">Documents Management</h2>

            <p class="text-muted mb-0">
                View, monitor, and archive faculty documents. Approval is handled by HR Staff.
            </p>

        </div>

        <a href="archive_documents.php" class="btn btn-secondary">
            <i class="bi bi-archive-fill"></i> View Archived
        </a>

    </div>
    <div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <!-- Search -->

                <div class="col-lg-4">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search faculty or document..."
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

                </div>

                <!-- Category -->

                <div class="col-lg-3">

                    <select name="category" class="form-select">

                        <option value="">All Categories</option>

                        <?php

                        $categoryQuery=mysqli_query($conn,"
                        SELECT *
                        FROM document_categories
                        ORDER BY category_name ASC
                        ");

                        while($cat=mysqli_fetch_assoc($categoryQuery))
                        {

                        ?>

                        <option
                        value="<?php echo $cat['category_id'];?>"

                        <?php

                        if(isset($_GET['category']) &&
                           $_GET['category']==$cat['category_id'])
                        {
                            echo "selected";
                        }

                        ?>

                        >

                        <?php echo htmlspecialchars($cat['category_name']);?>

                        </option>

                        <?php

                        }

                        ?>

                    </select>

                </div>

                <!-- Status -->

                <div class="col-lg-3">

                    <select name="status" class="form-select">

                        <option value="">All Status</option>

                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Returned">Returned</option>

                    </select>

                </div>

                <!-- Buttons -->

                <div class="col-lg-2 d-grid">

                    <button class="btn btn-primary">

                        <i class="bi bi-search"></i>

                        Search

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
<?php

$where = "WHERE 1=1 AND (documents.is_archived IS NULL OR documents.is_archived = 0)";

if (!empty($_GET['search'])) {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $where .= " AND (
        users.first_name LIKE '%$search%'
        OR users.last_name LIKE '%$search%'
        OR documents.document_title LIKE '%$search%'
    )";
}

if (!empty($_GET['category'])) {

    $category = (int)$_GET['category'];

    $where .= " AND documents.category_id=$category";
}

if (!empty($_GET['status'])) {

    $status = mysqli_real_escape_string($conn, $_GET['status']);

    $where .= " AND documents.status='$status'";
}

$query = mysqli_query($conn, "

SELECT

documents.*,

users.first_name,

users.last_name,

document_categories.category_name

FROM documents

LEFT JOIN users

ON users.user_id = documents.user_id

LEFT JOIN document_categories

ON document_categories.category_id = documents.category_id

$where

ORDER BY documents.submitted_at DESC

");

?>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">

            <i class="bi bi-folder2-open"></i>

            Documents

        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Faculty</th>

                        <th>Document</th>

                        <th>Category</th>

                        <th>Status</th>

                        <th>Date</th>

                        <th width="220">Actions</th>

                    </tr>

                </thead>

                <tbody>

                <?php

                if(mysqli_num_rows($query)>0)

                {

                    while($row=mysqli_fetch_assoc($query))

                    {

                ?>

                    <tr>

                        <td>

                            <strong>

                            <?php

                            echo htmlspecialchars($row['first_name']." ".$row['last_name']);

                            ?>

                            </strong>

                        </td>

                        <td>

                            <?php echo htmlspecialchars($row['document_title']); ?>

                        </td>

                        <td>

                            <?php echo htmlspecialchars($row['category_name']); ?>

                        </td>

                        <td>

<?php

$status=$row['status'];

switch($status){

case "Pending":

echo "<span class='badge bg-warning text-dark'>$status</span>";

break;

case "Approved":

echo "<span class='badge bg-success'>$status</span>";

break;

case "Rejected":

echo "<span class='badge bg-danger'>$status</span>";

break;

case "Returned":

echo "<span class='badge bg-info text-dark'>$status</span>";

break;

default:

echo "<span class='badge bg-secondary'>$status</span>";

}

?>

                        </td>

                        <td>

                            <?php echo date("M d, Y",strtotime($row['submitted_at'])); ?>

                        </td>

                        <td>
<a href="<?php echo $row['file_path']; ?>" target="_blank" class="btn btn-sm btn-primary">

<i class="bi bi-eye-fill"></i>

</a>

<a href="faculty_profile.php?id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-info text-white">

<i class="bi bi-person-fill"></i>

</a>

<a href="archive_document_action.php?id=<?php echo $row['document_id']; ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Archive this document? It will be hidden from the main list but not deleted.')">

<i class="bi bi-archive-fill"></i>

</a>

                        </td>

                    </tr>

                <?php

                    }

                }

                else

                {

                ?>

<tr>

<td colspan="6" class="text-center text-muted">

No documents found.

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

<?php include "includes/footer.php"; ?>