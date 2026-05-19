<?php
require '../config/db.php';
require '../config/session.php';

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$_SESSION['user_id']]);

$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>

<title>My Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container py-5">

    <div class="card p-5">

        <h2>My Profile</h2>

        <hr>

        <p><strong>Name:</strong> <?= $user['name'] ?></p>

        <p><strong>Email:</strong> <?= $user['email'] ?></p>

        <p><strong>Role:</strong> <?= $user['role'] ?></p>

        <a href="edit_profile.php" class="btn btn-success">
            Edit Profile
        </a>

    </div>

</div>

</body>
</html>