<?php
require '../config/db.php';
require '../config/session.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? 'user';

/*
========================================
FETCH CLAIMS
========================================
ADMIN -> ALL CLAIMS
USER -> ONLY OWN CLAIMS
========================================
*/

if($role == 'admin'){

    $stmt = $pdo->prepare("
    SELECT 
        claims.*,
        found_items.item_name,
        found_items.category,
        found_items.location_found,
        users.name as user_name
    FROM claims

    LEFT JOIN found_items
    ON claims.item_id = found_items.id

    LEFT JOIN users
    ON claims.user_id = users.id

    ORDER BY claims.id DESC
    ");

    $stmt->execute();

}else{

    $stmt = $pdo->prepare("
    SELECT 
        claims.*,
        found_items.item_name,
        found_items.category,
        found_items.location_found
    FROM claims

    LEFT JOIN found_items
    ON claims.item_id = found_items.id

    WHERE claims.user_id=?

    ORDER BY claims.id DESC
    ");

    $stmt->execute([$user_id]);
}

$claims = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Claims | CampuRecover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

body{
    background:#F8FAFC;
    font-family:'Poppins',sans-serif;
}

/* NAVBAR */

.navbar-custom{
    background:linear-gradient(135deg,#0F766E,#115E59);
    padding:15px 25px;
}

.navbar-custom .navbar-brand{
    color:white;
    font-size:28px;
    font-weight:bold;
}

.navbar-custom a{
    color:white !important;
    margin-left:20px;
    text-decoration:none;
}

/* CARD */

.claim-card{
    background:white;
    border-radius:22px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

/* STATUS */

.badge-status{
    padding:10px 16px;
    border-radius:12px;
    font-size:14px;
}

.pending{
    background:#FEF3C7;
    color:#92400E;
}

.approved{
    background:#DCFCE7;
    color:#166534;
}

.rejected{
    background:#FEE2E2;
    color:#991B1B;
}

/* BUTTONS */

.btn-approve{
    background:#16A34A;
    color:white;
    border:none;
    border-radius:10px;
    padding:8px 14px;
}

.btn-reject{
    background:#DC2626;
    color:white;
    border:none;
    border-radius:10px;
    padding:8px 14px;
}

.table th{
    background:#0F766E;
    color:white;
}

.empty-box{
    background:white;
    border-radius:20px;
    padding:60px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

</style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-custom">

    <div class="container-fluid">

        <a class="navbar-brand"
        href="../dashboard.php">

            CampuRecover

        </a>

        <div>

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a href="search_items.php">
                Search Items
            </a>

            <a href="../logout.php">
                Logout
            </a>

        </div>

    </div>

</nav>

<!-- MAIN CONTENT -->

<div class="container py-5">

    <div class="claim-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">

                <?php if($role == 'admin'): ?>

                    All Claims

                <?php else: ?>

                    My Claims

                <?php endif; ?>

            </h2>

            <span class="badge bg-dark p-3">

                Total Claims:
                <?= count($claims) ?>

            </span>

        </div>

        <?php if(count($claims) > 0): ?>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <tr>

                    <th>Claim ID</th>

                    <?php if($role == 'admin'): ?>

                    <th>User</th>

                    <?php endif; ?>

                    <th>Item</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Date</th>

                    <?php if($role == 'admin'): ?>

                    <th>Actions</th>

                    <?php endif; ?>

                </tr>

                <?php foreach($claims as $claim): ?>

                <tr>

                    <td>
                        #<?= $claim['id'] ?>
                    </td>

                    <?php if($role == 'admin'): ?>

                    <td>

                        <?= $claim['user_name'] ?>

                    </td>

                    <?php endif; ?>

                    <td>

                        <?= $claim['item_name'] ?? 'Deleted Item' ?>

                    </td>

                    <td>

                        <?= $claim['category'] ?? 'N/A' ?>

                    </td>

                    <td>

                        <?= $claim['location_found'] ?? 'N/A' ?>

                    </td>

                    <td>

                        <?php
                        $status = strtolower($claim['status']);
                        ?>

                        <span class="badge-status <?= $status ?>">

                            <?= ucfirst($claim['status']) ?>

                        </span>

                    </td>

                    <td>

                        <?= date("d M Y",
                        strtotime($claim['created_at'])) ?>

                    </td>

                    <!-- ADMIN ACTIONS -->

                    <?php if($role == 'admin'): ?>

                    <td>

                        <?php if($claim['status'] == 'Pending'): ?>

                        <a
                        href="../admin/approve_claim.php?id=<?= $claim['id'] ?>"
                        class="btn btn-approve btn-sm">

                            Approve

                        </a>

                        <a
                        href="../admin/reject_claim.php?id=<?= $claim['id'] ?>"
                        class="btn btn-reject btn-sm">

                            Reject

                        </a>

                        <?php else: ?>

                            <span class="text-muted">

                                Action Completed

                            </span>

                        <?php endif; ?>

                    </td>

                    <?php endif; ?>

                </tr>

                <?php endforeach; ?>

            </table>

        </div>

        <?php else: ?>

        <div class="empty-box">

            <i class="fa fa-folder-open fa-4x text-muted mb-4"></i>

            <h3>
                No Claims Found
            </h3>

            <p class="text-muted">

                Your claim requests will appear here

            </p>

        </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>