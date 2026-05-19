<?php
require '../config/db.php';
require '../config/session.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

$search = "";

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

/*
========================================
SEARCH QUERY
========================================
*/

$stmt = $pdo->prepare("
SELECT * FROM found_items
WHERE item_name LIKE ?
OR category LIKE ?
OR description LIKE ?
ORDER BY id DESC
");

$stmt->execute([
    "%$search%",
    "%$search%",
    "%$search%"
]);

$items = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Search Items | CampuRecover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

body{
    background:#F8FAFC;
    font-family:'Poppins',sans-serif;
}

/* NAVBAR */

.custom-navbar{
    background:linear-gradient(135deg,#0F766E,#115E59);
    padding:15px 30px;
}

.custom-navbar .navbar-brand{
    color:white;
    font-size:28px;
    font-weight:bold;
}

.custom-navbar a{
    color:white !important;
    margin-left:20px;
    font-weight:500;
}

/* SEARCH BOX */

.search-box{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

/* CARDS */

.item-card{
    background:white;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    transition:0.3s;
    height:100%;
}

.item-card:hover{
    transform:translateY(-8px);
}

.item-card img{
    width:100%;
    height:250px;
    object-fit:cover;
}

.item-content{
    padding:20px;
}

.item-content h4{
    font-weight:700;
    color:#0F172A;
}

.badge-category{
    background:#14B8A6;
    color:white;
    padding:8px 12px;
    border-radius:10px;
    font-size:13px;
}

.btn-claim{
    background:#0F766E;
    color:white;
    border:none;
    border-radius:12px;
    padding:10px 18px;
    transition:0.3s;
}

.btn-claim:hover{
    background:#14B8A6;
    color:white;
}

.empty-box{
    background:white;
    padding:50px;
    text-align:center;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

</style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg custom-navbar">

    <div class="container-fluid">

        <a class="navbar-brand" href="../dashboard.php">

            CampuRecover

        </a>

        <div>

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a href="report_lost.php">
                Report Lost
            </a>

            <a href="report_found.php">
                Report Found
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

    <!-- SEARCH SECTION -->

    <div class="search-box mb-5">

        <div class="row align-items-center">

            <div class="col-md-6">

                <h2 class="fw-bold">
                    Search Found Items
                </h2>

                <p class="text-muted">
                    Find your lost belongings quickly
                </p>

            </div>

            <div class="col-md-6">

                <form method="GET">

                    <div class="input-group">

                        <input
                            type="text"
                            name="search"
                            class="form-control form-control-lg"
                            placeholder="Search by item name, category..."
                            value="<?= htmlspecialchars($search) ?>"
                        >

                        <button class="btn btn-success btn-lg">

                            <i class="fa fa-search"></i>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- ITEMS -->

    <div class="row">

        <?php if(count($items) > 0): ?>

            <?php foreach($items as $item): ?>

                <div class="col-md-4 mb-4">

                    <div class="item-card">

                        <?php if(!empty($item['item_image'])): ?>

                            <img
                            src="../assets/uploads/found_items/<?= $item['item_image'] ?>">

                        <?php else: ?>

                            <img
                            src="https://via.placeholder.com/400x250?text=No+Image">

                        <?php endif; ?>

                        <div class="item-content">

                            <span class="badge-category">

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
                                    Location:
                                </strong>

                                <?= $item['location_found'] ?>

                            </p>

                            <?php if(isset($item['date_found'])): ?>

                            <p>

                                <strong>
                                    Date:
                                </strong>

                                <?= $item['date_found'] ?>

                            </p>

                            <?php endif; ?>

                            <!-- CLAIM BUTTON -->

                            <a
                            href="claim_item.php?id=<?= $item['id'] ?>"
                            class="btn btn-claim w-100">

                                <i class="fa fa-hand"></i>

                                Claim Item

                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="col-12">

                <div class="empty-box">

                    <i class="fa fa-box-open fa-4x text-muted mb-4"></i>

                    <h3>
                        No Items Found
                    </h3>

                    <p class="text-muted">

                        Try searching with another keyword

                    </p>

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>