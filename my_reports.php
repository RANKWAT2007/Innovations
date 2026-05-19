<?php
require '../config/db.php';
require '../config/session.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/*
========================================
FETCH USER REPORTS
========================================
*/

$stmt = $pdo->prepare("
SELECT * FROM lost_items
WHERE user_id=?
ORDER BY id DESC
");

$stmt->execute([$user_id]);

$items = $stmt->fetchAll();

/*
========================================
TOTAL REPORTS
========================================
*/

$countStmt = $pdo->prepare("
SELECT COUNT(*) FROM lost_items
WHERE user_id=?
");

$countStmt->execute([$user_id]);

$totalReports = $countStmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Reports | CampuRecover</title>

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
    text-decoration:none;
    margin-left:20px;
    font-weight:500;
}

/* PAGE HEADER */

.page-header{
    background:white;
    border-radius:22px;
    padding:30px;
    margin-bottom:30px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

/* REPORT CARD */

.report-card{
    background:white;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    transition:0.3s;
    height:100%;
}

.report-card:hover{
    transform:translateY(-8px);
}

.report-card img{
    width:100%;
    height:250px;
    object-fit:cover;
}

.report-content{
    padding:22px;
}

.report-content h4{
    font-weight:700;
    margin-bottom:15px;
}

.badge-custom{
    background:#14B8A6;
    color:white;
    padding:8px 14px;
    border-radius:10px;
    font-size:13px;
}

/* BUTTONS */

.btn-edit{
    background:#2563EB;
    color:white;
    border:none;
    border-radius:12px;
    padding:10px 16px;
}

.btn-delete{
    background:#DC2626;
    color:white;
    border:none;
    border-radius:12px;
    padding:10px 16px;
}

.btn-edit:hover{
    background:#1D4ED8;
    color:white;
}

.btn-delete:hover{
    background:#B91C1C;
    color:white;
}

/* EMPTY BOX */

.empty-box{
    background:white;
    border-radius:22px;
    padding:60px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

.empty-box i{
    font-size:70px;
    color:#94A3B8;
    margin-bottom:20px;
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

            <a href="report_lost.php">
                Report Lost
            </a>

            <a href="search_items.php">
                Search Items
            </a>

            <a href="my_claims.php">
                My Claims
            </a>

            <a href="../logout.php">
                Logout
            </a>

        </div>

    </div>

</nav>

<!-- MAIN CONTENT -->

<div class="container py-5">

    <!-- PAGE HEADER -->

    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h2 class="fw-bold">

                    My Lost Reports

                </h2>

                <p class="text-muted mb-0">

                    Manage all your reported lost items

                </p>

            </div>

            <div>

                <span class="badge bg-dark p-3">

                    Total Reports:
                    <?= $totalReports ?>

                </span>

            </div>

        </div>

    </div>

    <!-- REPORTS -->

    <div class="row">

        <?php if(count($items) > 0): ?>

            <?php foreach($items as $item): ?>

                <div class="col-md-4 mb-4">

                    <div class="report-card">

                        <!-- IMAGE -->

                        <?php if(!empty($item['item_image'])): ?>

                            <img
                            src="../assets/uploads/lost_items/<?= $item['item_image'] ?>">

                        <?php else: ?>

                            <img
                            src="https://via.placeholder.com/400x250?text=No+Image">

                        <?php endif; ?>

                        <!-- CONTENT -->

                        <div class="report-content">

                            <span class="badge-custom">

                                <?= $item['category'] ?>

                            </span>

                            <h4 class="mt-3">

                                <?= $item['item_name'] ?>

                            </h4>

                            <p class="text-muted">

                                <?= $item['description'] ?>

                            </p>

                            <p>

                                <strong>
                                    Lost Location:
                                </strong>

                                <?= $item['location_lost'] ?>

                            </p>

                            <?php if(isset($item['date_lost'])): ?>

                            <p>

                                <strong>
                                    Lost Date:
                                </strong>

                                <?= $item['date_lost'] ?>

                            </p>

                            <?php endif; ?>

                            <!-- ACTION BUTTONS -->

                            <div class="d-flex gap-2 mt-4">

                                <a
                                href="edit_report.php?id=<?= $item['id'] ?>"
                                class="btn btn-edit w-50">

                                    <i class="fa fa-pen"></i>

                                    Edit

                                </a>

                                <a
                                href="delete_report.php?id=<?= $item['id'] ?>"
                                class="btn btn-delete w-50"
                                onclick="return confirm('Are you sure you want to delete this report?')">

                                    <i class="fa fa-trash"></i>

                                    Delete

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <!-- EMPTY STATE -->

            <div class="col-12">

                <div class="empty-box">

                    <i class="fa fa-folder-open"></i>

                    <h3>
                        No Lost Reports Found
                    </h3>

                    <p class="text-muted">

                        You haven't reported any lost items yet.

                    </p>

                    <a
                    href="report_lost.php"
                    class="btn btn-success mt-3">

                        Report Lost Item

                    </a>

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>