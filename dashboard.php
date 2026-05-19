<?php
require 'config/db.php';
require 'config/session.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

/*
========================================
CHECK IF user_id COLUMN EXISTS
========================================
*/

function columnExists($pdo, $table, $column){

    $query = $pdo->prepare("
        SHOW COLUMNS FROM $table LIKE ?
    ");

    $query->execute([$column]);

    return $query->rowCount() > 0;
}

$hasUserIdLost = columnExists($pdo, 'lost_items', 'user_id');
$hasUserIdFound = columnExists($pdo, 'found_items', 'user_id');
$hasUserIdClaims = columnExists($pdo, 'claims', 'user_id');

/*
========================================
FETCH USER DATA SAFELY
========================================
*/

$user_id = $_SESSION['user_id'];

/* LOST ITEMS */

if($hasUserIdLost){

    $lostCount = $pdo->prepare("
    SELECT COUNT(*) FROM lost_items
    WHERE user_id=?
    ");

    $lostCount->execute([$user_id]);

}else{

    $lostCount = $pdo->query("
    SELECT COUNT(*) FROM lost_items
    ");
}

$totalLost = $lostCount->fetchColumn();

/* FOUND ITEMS */

if($hasUserIdFound){

    $foundCount = $pdo->prepare("
    SELECT COUNT(*) FROM found_items
    WHERE user_id=?
    ");

    $foundCount->execute([$user_id]);

}else{

    $foundCount = $pdo->query("
    SELECT COUNT(*) FROM found_items
    ");
}

$totalFound = $foundCount->fetchColumn();

/* CLAIMS */

if($hasUserIdClaims){

    $claimCount = $pdo->prepare("
    SELECT COUNT(*) FROM claims
    WHERE user_id=?
    ");

    $claimCount->execute([$user_id]);

}else{

    $claimCount = $pdo->query("
    SELECT COUNT(*) FROM claims
    ");
}

$totalClaims = $claimCount->fetchColumn();

/* RECENT ITEMS */

if($hasUserIdLost){

    $recentItems = $pdo->prepare("
    SELECT * FROM lost_items
    WHERE user_id=?
    ORDER BY id DESC
    LIMIT 5
    ");

    $recentItems->execute([$user_id]);

}else{

    $recentItems = $pdo->query("
    SELECT * FROM lost_items
    ORDER BY id DESC
    LIMIT 5
    ");
}

$items = $recentItems->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard | CampuRecover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

body{
    background:#F8FAFC;
    font-family:'Poppins',sans-serif;
}

/* SIDEBAR */

.sidebar{
    width:260px;
    height:100vh;
    background:linear-gradient(180deg,#0F766E,#115E59);
    position:fixed;
    padding:30px 20px;
    color:white;
}

.sidebar h2{
    margin-bottom:40px;
    font-weight:bold;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:14px 18px;
    border-radius:14px;
    margin-bottom:15px;
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
    border-radius:20px;
    padding:20px 25px;
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
    position:relative;
    overflow:hidden;
    transition:0.3s;
}

.dashboard-card:hover{
    transform:translateY(-5px);
}

.dashboard-card i{
    position:absolute;
    right:20px;
    top:20px;
    font-size:50px;
    opacity:0.3;
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

.card-notify{
    background:linear-gradient(135deg,#0F766E,#14B8A6);
}

/* QUICK ACTION */

.quick-action{
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

/* TABLE */

.custom-table{
    background:white;
    border-radius:20px;
    padding:25px;
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
}

.btn-custom:hover{
    background:#14B8A6;
    color:white;
}

/* PROFILE */

.profile-box{
    display:flex;
    align-items:center;
    gap:15px;
}

.profile-box img{
    width:55px;
    height:55px;
    border-radius:50%;
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h2>CampuRecover</h2>

    <a href="dashboard.php">
        <i class="fa fa-chart-line"></i>
        Dashboard
    </a>

    <a href="user/report_lost.php">
        <i class="fa fa-triangle-exclamation"></i>
        Report Lost
    </a>

    <a href="user/report_found.php">
        <i class="fa fa-circle-check"></i>
        Report Found
    </a>

    <a href="user/search_items.php">
        <i class="fa fa-search"></i>
        Search Items
    </a>

    <a href="user/my_reports.php">
        <i class="fa fa-folder"></i>
        My Reports
    </a>

    <a href="logout.php">
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
                Welcome,
                <?= $_SESSION['user_name']; ?> 👋
            </h3>

            <p class="text-muted mb-0">
                Manage your lost & found items easily
            </p>

        </div>

        <div class="profile-box">

            <img
            src="https://ui-avatars.com/api/?name=<?= $_SESSION['user_name']; ?>&background=0F766E&color=fff">

        </div>

    </div>

    <!-- STATS -->

    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="dashboard-card card-lost">

                <i class="fa fa-triangle-exclamation"></i>

                <h5>Lost Items</h5>

                <h1><?= $totalLost ?></h1>

            </div>

        </div>

        <div class="col-md-3">

            <div class="dashboard-card card-found">

                <i class="fa fa-circle-check"></i>

                <h5>Found Items</h5>

                <h1><?= $totalFound ?></h1>

            </div>

        </div>

        <div class="col-md-3">

            <div class="dashboard-card card-claims">

                <i class="fa fa-file-signature"></i>

                <h5>Claims</h5>

                <h1><?= $totalClaims ?></h1>

            </div>

        </div>

        <div class="col-md-3">

            <div class="dashboard-card card-notify">

                <i class="fa fa-bell"></i>

                <h5>Notifications</h5>

                <h1>3</h1>

            </div>

        </div>

    </div>

    <!-- RECENT ITEMS -->

    <div class="custom-table">

        <div class="d-flex justify-content-between mb-3">

            <h4>Recent Lost Items</h4>

            <a href="user/my_reports.php"
            class="btn btn-custom">

                View All

            </a>

        </div>

        <table class="table table-hover">

            <tr>

                <th>ID</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Location</th>

            </tr>

            <?php foreach($items as $item): ?>

            <tr>

                <td><?= $item['id'] ?></td>

                <td><?= $item['item_name'] ?></td>

                <td><?= $item['category'] ?></td>

                <td><?= $item['location_lost'] ?></td>

            </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>

</body>
</html>