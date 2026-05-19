<?php
require '../config/db.php';

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

<title>Manage Claims</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#F8FAFC;
    font-family:Poppins;
}

.navbar{
    background:#0F766E;
}

.card-box{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

.btn-approve{background:#16A34A;color:white;}
.btn-reject{background:#DC2626;color:white;}

</style>

</head>

<body>

<nav class="navbar navbar-dark px-4">
    <a class="navbar-brand" href="#">Admin Panel</a>
</nav>

<div class="container py-5">

<div class="card-box">

<h3 class="mb-4">Manage Claims</h3>

<table class="table table-hover">

<tr>
<th>ID</th>
<th>User</th>
<th>Item</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php foreach($claims as $c): ?>

<tr>

<td><?= $c['id'] ?></td>
<td><?= $c['name'] ?></td>
<td><?= $c['item_name'] ?></td>

<td>
    <span class="badge bg-warning text-dark">
        <?= $c['status'] ?>
    </span>
</td>

<td>

<a href="approve_claim.php?id=<?= $c['id'] ?>"
class="btn btn-approve btn-sm">
Approve
</a>

<a href="reject_claim.php?id=<?= $c['id'] ?>"
class="btn btn-reject btn-sm">
Reject
</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</div>

</body>
</html>