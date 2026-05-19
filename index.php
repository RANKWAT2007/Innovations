<?php
require '../config/db.php';
require '../config/session.php';

/*
========================================
FETCH DATA
========================================
*/

$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

$totalLost = $pdo->query("SELECT COUNT(*) FROM lost_items")->fetchColumn();

$totalFound = $pdo->query("SELECT COUNT(*) FROM found_items")->fetchColumn();

$totalClaims = $pdo->query("SELECT COUNT(*) FROM claims")->fetchColumn();

$recentLost = $pdo->query("
SELECT * FROM lost_items
ORDER BY id DESC
LIMIT 5
")->fetchAll();

$recentFound = $pdo->query("
SELECT * FROM found_items
ORDER BY id DESC
LIMIT 5
")->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CampuRecover Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

body{
    background:#F8FAFC;
    font-family:Segoe UI;
}

/* SIDEBAR */

.sidebar{
    width:260px;
    height:100vh;
    position:fixed;
    background:linear-gradient(180deg,#0F766E,#115E59);
    padding:30px 20px;
    color:white;
}

.sidebar h2{
    font-weight:bold;
    margin-bottom:40px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:14px 18px;
    border-radius:12px;
    margin-bottom:12px;
    transition:0.3s;
    font-size:16px;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.15);
    transform:translateX(5px);
}

/* MAIN CONTENT */

.main-content{
    margin-left:280px;
    padding:30px;
}

/* TOPBAR */

.topbar{
    background:white;
    padding:18px 25px;
    border-radius:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

/* CARDS */

.dashboard-card{
    border:none;
    border-radius:22px;
    padding:25px;
    color:white;
    transition:0.3s;
    overflow:hidden;
    position:relative;
}

.dashboard-card:hover{
    transform:translateY(-6px);
}

.dashboard-card i{
    font-size:45px;
    opacity:0.3;
    position:absolute;
    right:20px;
    top:20px;
}

.card-users{
    background:linear-gradient(135deg,#0F766E,#14B8A6);
}

.card-lost{
    background:linear-gradient(135deg,#DC2626,#F87171);
}

.card-found{
    background:linear-gradient(135deg,#2563EB,#60A5FA);
}

.card-claims{
    background:linear-gradient(135deg,#7C3AED,#A78BFA);
}

/* TABLES */

.custom-table{
    background:white;
    border-radius:20px;
    padding:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

.table th{
    background:#0F766E;
    color:white;
}

/* BUTTONS */

.btn-custom{
    background:#0F766E;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:12px;
    transition:0.3s;
}

.btn-custom:hover{
    background:#14B8A6;
    color:white;
}

/* BADGES */

.badge-custom{
    background:#14B8A6;
    padding:8px 12px;
    border-radius:10px;
}

/* QUICK ACTIONS */

.quick-btn{
    width:100%;
    margin-bottom:15px;
    padding:15px;
    border:none;
    border-radius:15px;
    font-weight:600;
    transition:0.3s;
}

.quick-btn:hover{
    transform:scale(1.03);
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h2>
        CampuRecover
    </h2>

    <a href="index.php">
        <i class="fa fa-chart-line"></i>
        Dashboard
    </a>

    <a href="manage_users.php">
        <i class="fa fa-users"></i>
        Manage Users
    </a>

    <a href="manage_reports.php">
        <i class="fa fa-box-open"></i>
        Lost Reports
    </a>

    <a href="reports.php">
        <i class="fa fa-check-circle"></i>
        Found Reports
    </a>

    <a href="manage_claims.php">
        <i class="fa fa-file-circle-check"></i>
        Claims
    </a>

    <a href="analytics.php">
        <i class="fa fa-chart-pie"></i>
        Analytics
    </a>

    <a href="../logout.php">
        <i class="fa fa-right-from-bracket"></i>
        Logout
    </a>

</div>

<!-- MAIN CONTENT -->

<div class="main-content">

    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h3 class="fw-bold">
                Welcome Admin 👋
            </h3>

            <p class="text-muted mb-0">
                CampuRecover Management Dashboard
            </p>

        </div>

        <div>

            <span class="badge-custom">
                Admin Panel
            </span>

        </div>

    </div>

    <!-- STATS -->

    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="dashboard-card card-users">

                <i class="fa fa-users"></i>

                <h5>Total Users</h5>

                <h1>
                    <?= $totalUsers ?>
                </h1>

            </div>

        </div>

        <div class="col-md-3">

            <div class="dashboard-card card-lost">

                <i class="fa fa-triangle-exclamation"></i>

                <h5>Lost Items</h5>

                <h1>
                    <?= $totalLost ?>
                </h1>

            </div>

        </div>

        <div class="col-md-3">

            <div class="dashboard-card card-found">

                <i class="fa fa-circle-check"></i>

                <h5>Found Items</h5>

                <h1>
                    <?= $totalFound ?>
                </h1>

            </div>

        </div>

        <div class="col-md-3">

            <div class="dashboard-card card-claims">

                <i class="fa fa-file-signature"></i>

                <h5>Total Claims</h5>

                <h1>
                    <?= $totalClaims ?>
                </h1>

            </div>

        </div>

    </div>

<!-- ACTION BUTTONS PANEL -->
<div class="container py-5">

<div class="card p-4 shadow-sm" style="border-radius:20px;">

<h3 class="mb-4">Admin Actions</h3>

<div class="row g-4">

<!-- GENERATE REPORT -->
<div class="col-md-4">

<a href="generate_report.php"
class="btn w-100 p-4 text-white"
style="background:#0F766E;border-radius:18px;">

<h5>📊 Generate Report</h5>
<p class="mb-0">View system analytics</p>

</a>

</div>

<!-- CSV EXPORT -->
<div class="col-md-4">

<a href="export_csv.php"
class="btn w-100 p-4 text-white"
style="background:#2563EB;border-radius:18px;">

<h5>📁 Export CSV</h5>
<p class="mb-0">Download claims data</p>

</a>

</div>

<!-- ADD DEPARTMENT -->
<div class="col-md-4">

<a href="add_department.php"
class="btn w-100 p-4 text-white"
style="background:#F59E0B;border-radius:18px;">

<h5>🏢 Add Department</h5>
<p class="mb-0">Manage college departments</p>

</a>

</div>

</div>

</div>

</div>
    <!-- RECENT LOST ITEMS -->

    <div class="custom-table mb-5">

        <div class="d-flex justify-content-between mb-3">

            <h4>
                Recent Lost Items
            </h4>

            <a href="manage_reports.php" class="btn btn-custom">
                View All
            </a>

        </div>

        <table class="table table-hover">

            <tr>

                <th>ID</th>
                <th>Item</th>
                <th>Category</th>
                <th>Location</th>

            </tr>

            <?php foreach($recentLost as $item): ?>

            <tr>

                <td><?= $item['id'] ?></td>

                <td><?= $item['item_name'] ?></td>

                <td><?= $item['category'] ?></td>

                <td><?= $item['location_lost'] ?></td>

            </tr>

            <?php endforeach; ?>

        </table>

    </div>

    <!-- RECENT FOUND ITEMS -->

    <div class="custom-table">

        <div class="d-flex justify-content-between mb-3">

            <h4>
                Recent Found Items
            </h4>

            <a href="reports.php" class="btn btn-custom">
                View All
            </a>

        </div>

        <table class="table table-hover">

            <tr>

                <th>ID</th>
                <th>Item</th>
                <th>Category</th>
                <th>Location</th>

            </tr>

            <?php foreach($recentFound as $item): ?>

            <tr>

                <td><?= $item['id'] ?></td>

                <td><?= $item['item_name'] ?></td>

                <td><?= $item['category'] ?></td>

                <td><?= $item['location_found'] ?></td>

            </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>

</body>
</html>