<?php
require '../config/db.php';

$reports = $pdo->query("
SELECT lost_items.*, users.name AS user_name, departments.name AS dept_name
FROM lost_items
LEFT JOIN users ON lost_items.user_id = users.id
LEFT JOIN departments ON lost_items.department_id = departments.id
ORDER BY lost_items.id DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Lost Reports</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#F8FAFC;font-family:Poppins;}

.navbar{background:#0F766E;}

.item-card{
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    transition:0.3s;
    background:white;
}

.item-card:hover{transform:translateY(-5px);}

.item-img{width:100%;height:200px;object-fit:cover;}

.badge-teal{
    background:#0F766E;color:white;
    padding:6px 12px;border-radius:10px;font-size:12px;
}
</style>

</head>

<body>

<nav class="navbar navbar-dark px-4">
    <a class="navbar-brand">Admin - Lost Reports</a>
</nav>

<div class="container py-5">

<div class="row">

<?php foreach($reports as $r): ?>

<div class="col-md-4 mb-4">

<div class="item-card">

<?php if(!empty($r['item_image'])): ?>
<img class="item-img" src="../assets/uploads/lost_items/<?= $r['item_image'] ?>">
<?php endif; ?>

<div class="p-3">

<span class="badge-teal"><?= $r['category'] ?></span>

<h5 class="mt-2"><?= $r['item_name'] ?></h5>

<p><?= $r['description'] ?></p>

<p><b>Location:</b> <?= $r['location_lost'] ?></p>

<p><b>Department:</b> <?= $r['dept_name'] ?? 'Not Assigned' ?></p>

<p><b>Reported By:</b> <?= $r['user_name'] ?></p>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

</body>
</html>