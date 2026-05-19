<?php
require '../config/session.php';

$notifications = [
    "Your lost item may have a match.",
    "Admin approved your claim.",
    "New found item uploaded."
];
?>

<!DOCTYPE html>
<html>
<head>

<title>Notifications</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container py-5">

    <h2 class="mb-4">Notifications</h2>

    <?php foreach($notifications as $note): ?>

        <div class="alert alert-success">

            <?= $note ?>

        </div>

    <?php endforeach; ?>

</div>

</body>
</html>