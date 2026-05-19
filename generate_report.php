<?php
require '../config/db.php';

/*
========================================
FETCH FULL DATA
========================================
*/

$lostItems = $pdo->query("
SELECT lost_items.*, users.name 
FROM lost_items 
LEFT JOIN users ON lost_items.user_id = users.id
ORDER BY lost_items.id DESC
")->fetchAll();

$foundItems = $pdo->query("
SELECT found_items.*, users.name 
FROM found_items 
LEFT JOIN users ON found_items.user_id = users.id
ORDER BY found_items.id DESC
")->fetchAll();

$claims = $pdo->query("
SELECT claims.*, users.name, found_items.item_name
FROM claims
LEFT JOIN users ON claims.user_id = users.id
LEFT JOIN found_items ON claims.item_id = found_items.id
ORDER BY claims.id DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>

<title>Full System Report</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#F8FAFC;
    font-family:Poppins;
}

.navbar{
    background:#0F766E;
}

.section-box{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.card-item{
    border:1px solid #eee;
    border-radius:15px;
    padding:15px;
    margin-bottom:15px;
}

img{
    border-radius:10px;
}

.badge-pending{background:#FBBF24;color:black;}
.badge-approved{background:#22C55E;color:white;}
.badge-rejected{background:#EF4444;color:white;}

</style>

</head>

<body>

<nav class="navbar navbar-dark px-4">
    <a class="navbar-brand">Full System Report</a>
</nav>

<div class="container py-5">

<!-- LOST ITEMS -->

<div class="section-box">

<h3>📍 Lost Items Report</h3>

<?php foreach($lostItems as $item): ?>

<div class="card-item">

<div class="row">

<div class="col-md-3">

<?php if(!empty($item['item_image'])): ?>

<img src="../assets/uploads/lost_items/<?= $item['item_image'] ?>" width="100%">

<?php endif; ?>

</div>

<div class="col-md-9">

<h5><?= $item['item_name'] ?></h5>

<p><?= $item['description'] ?></p>

<p><strong>Lost Location:</strong> <?= $item['location_lost'] ?></p>

<p><strong>Reported By:</strong> <?= $item['name'] ?></p>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<!-- FOUND ITEMS -->

<div class="section-box">

<h3>📍 Found Items Report</h3>

<?php foreach($foundItems as $item): ?>

<div class="card-item">

<div class="row">

<div class="col-md-3">

<?php if(!empty($item['item_image'])): ?>

<img src="../assets/uploads/found_items/<?= $item['item_image'] ?>" width="100%">

<?php endif; ?>

</div>

<div class="col-md-9">

<h5><?= $item['item_name'] ?></h5>

<p><?= $item['description'] ?></p>

<p><strong>Found Location:</strong> <?= $item['location_found'] ?></p>

<p><strong>Found By:</strong> <?= $item['name'] ?></p>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<!-- CLAIMS -->

<div class="section-box">

<h3>📍 Claims Report</h3>

<?php foreach($claims as $c): ?>

<div class="card-item">

<h5>Claim ID: <?= $c['id'] ?></h5>

<p><strong>User:</strong> <?= $c['name'] ?></p>

<p><strong>Item:</strong> <?= $c['item_name'] ?></p>

<p>
<strong>Status:</strong>

<span class="
<?=
($c['status']=='Pending')?'badge-pending':
(($c['status']=='Approved')?'badge-approved':'badge-rejected')
?>
badge p-2">

<?= $c['status'] ?>

</span>

</p>

</div>

<?php endforeach; ?>

</div>

</div>

</body>
</html>