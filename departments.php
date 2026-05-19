<?php
require '../config/db.php';

$departments = $pdo->query("SELECT * FROM departments ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Departments</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#F8FAFC;font-family:Poppins;}

.card-box{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}
</style>

</head>

<body>

<div class="container py-5">

<h2>Departments</h2>

<div class="card-box mt-4">

<ul class="list-group">

<?php foreach($departments as $d): ?>

<li class="list-group-item d-flex justify-content-between">

<?= $d['name'] ?>

<span class="text-muted">ID: <?= $d['id'] ?></span>

</li>

<?php endforeach; ?>

</ul>

</div>

</div>

</body>
</html>