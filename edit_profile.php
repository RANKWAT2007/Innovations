<?php
require '../config/db.php';
require '../config/session.php';

$message = "";

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$_SESSION['user_id']]);

$user = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'];

    $stmt = $pdo->prepare("UPDATE users SET name=? WHERE id=?");

    $stmt->execute([$name,$_SESSION['user_id']]);

    $message = "Profile Updated";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container py-5">

    <div class="card p-5">

        <h2>Edit Profile</h2>

        <?php if($message): ?>

            <div class="alert alert-success">
                <?= $message ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <input
                type="text"
                name="name"
                class="form-control mb-3"
                value="<?= $user['name'] ?>"
            >

            <button class="btn btn-success">
                Save Changes
            </button>

        </form>

    </div>

</div>

</body>
</html>