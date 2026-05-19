<?php
require '../config/db.php';

$users = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Users</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#F8FAFC;
    font-family:Poppins;
}

.navbar{
    background:#0F766E;
}

.user-card{
    background:white;
    padding:20px;
    border-radius:18px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    text-align:center;
}

.avatar{
    width:80px;
    height:80px;
    border-radius:50%;
    margin-bottom:10px;
}

</style>

</head>

<body>

<nav class="navbar navbar-dark px-4">
    <a class="navbar-brand">Admin Panel - Users</a>
</nav>

<div class="container py-5">

<div class="row">

<?php foreach($users as $u): ?>

<div class="col-md-3 mb-4">

<div class="user-card">

<img class="avatar"
src="https://ui-avatars.com/api/?name=<?= $u['name'] ?>">

<h5><?= $u['name'] ?></h5>
<p class="text-muted"><?= $u['email'] ?></p>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

</body>
</html>