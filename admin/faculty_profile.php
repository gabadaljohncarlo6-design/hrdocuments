<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$user_id=(int)$_GET['id'];

$user=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT *
FROM users
WHERE user_id=$user_id
"));

include "includes/header.php";
include "includes/sidebar.php";
?>
<div class="container-fluid" style="max-width:1600px;">

<div class="page-header mb-4 d-flex justify-content-between align-items-center">
    <h1 class="fw-bold">Faculty Profile</h1>
    <a href="users.php" class="btn btn-secondary">← Back</a>
</div>

<?php
$documents = mysqli_query($conn,"
SELECT d.*, dc.category_name
FROM documents d
LEFT JOIN document_categories dc
ON d.category_id = dc.category_id
WHERE d.user_id = $user_id
ORDER BY d.submitted_at DESC
");

$total_docs = mysqli_num_rows($documents);
?>

<div class="row g-4 align-items-start">

    <!-- PROFILE -->
<div class="col-xl-4 col-lg-5">

        <div class="profile-card h-100">

            <div class="text-center mb-5">

                <?php if (!empty($user['profile_picture']) && file_exists('../uploads/profile_pictures/'.$user['profile_picture'])): ?>
                    <img src="../uploads/profile_pictures/<?= htmlspecialchars($user['profile_picture']); ?>"
                         class="avatar mx-auto mb-3" style="object-fit:cover;">
                <?php else: ?>
                    <div class="avatar mx-auto mb-3">
                        <?= strtoupper(substr($user['first_name'],0,1)); ?>
                    </div>
                <?php endif; ?>

                <h3 class="fw-bold">
                    <?= htmlspecialchars($user['first_name'].' '.$user['middle_name'].' '.$user['last_name']); ?>
                </h3>

                <span class="badge bg-primary">
                    <?= htmlspecialchars($user['role']); ?>
                </span>

            </div>

            <hr>

            <div class="profile-grid">

                <div>
                    <label>Employee ID</label>
                    <p><?= htmlspecialchars($user['employee_id']); ?></p>
                </div>

                <div>
                    <label>Email</label>
                    <p><?= htmlspecialchars($user['email']); ?></p>
                </div>

                <div>
                    <label>Department</label>
                    <p><?= htmlspecialchars($user['department']); ?></p>
                </div>

                <div>
                    <label>Position</label>
                    <p><?= htmlspecialchars($user['position_title']); ?></p>
                </div>

                <div>
                    <label>Status</label>
                    <p><?= htmlspecialchars($user['status']); ?></p>
                </div>

                <div>
                    <label>Registered</label>
                    <p><?= date("F d, Y",strtotime($user['created_at'])); ?></p>
                </div>

            </div>

        </div>

    </div>

    <!-- DOCUMENTS -->
<div class="col-xl-8 col-lg-7">

        <div class="documents-card h-100">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h2 class="mb-0">All Documents</h2>

                <span class="badge bg-primary">
                    <?= $total_docs ?> Documents
                </span>

            </div>

            <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>View</th>
                    </tr>

                </thead>

                <tbody>

                <?php if(mysqli_num_rows($documents)>0): ?>

                    <?php while($doc=mysqli_fetch_assoc($documents)): ?>

                    <?php

                    $color="secondary";

                    if($doc['status']=="Approved") $color="success";
                    elseif($doc['status']=="Pending") $color="warning";
                    elseif($doc['status']=="Rejected") $color="danger";
                    elseif($doc['status']=="Final Approved") $color="primary";

                    ?>

                    <tr>

                        <td><?= htmlspecialchars($doc['document_title']) ?></td>

                        <td><?= htmlspecialchars($doc['category_name']) ?></td>

                        <td>
                            <span class="badge bg-<?= $color ?>">
                                <?= htmlspecialchars($doc['status']) ?>
                            </span>
                        </td>

                        <td>
                            <?= date("F d, Y",strtotime($doc['submitted_at'])) ?>
                        </td>

                        <td>
                            <a href="document_review.php?id=<?= $doc['document_id'] ?>" class="btn btn-primary btn-sm">
                                View
                            </a>
                        </td>

                    </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="5" class="text-center py-5">
                            No documents found.
                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

            </div>

        </div>

    </div>

</div>



<?php
include "includes/footer.php";
?>