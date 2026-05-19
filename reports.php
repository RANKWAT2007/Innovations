<?php
require '../config/db.php';

$reports = $pdo->query("SELECT * FROM found_items ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Found Items</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#F8FAFC;
    font-family:Poppins;
}

.navbar{
    background:#0F766E;
}

.item-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    transition:0.3s;
}

.item-card:hover{
    transform:scale(1.02);
}

.img-box{
    height:200px;
    width:100%;
    object-fit:cover;
}

</style>

</head>

<body>

<nav class="navbar navbar-dark px-4">
    <a class="navbar-brand">Admin Panel - Found Items</a>
</nav>

<div class="container py-5">

<div class="row">

<?php foreach($reports as $r): ?>

<div class="col-md-4 mb-4">

<div class="item-card">

<?php if(!empty($r['item_image'])): ?>
<img class="img-box" src="../assets/uploads/found_items/<?= $r['item_image'] ?>">
<?php endif; ?>

<div class="p-3">

<h5><?= $r['item_name'] ?></h5>

<p class="text-muted">
<?= $r['description'] ?>
</p>

<p>
<strong>Location:</strong>
<?= $r['location_found'] ?>
</p>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

</body>
</html>