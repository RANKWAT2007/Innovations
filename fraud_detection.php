<?php
$suspiciousUsers = [
    "Multiple fake claims detected",
    "Duplicate item uploads found",
    "Spam activity identified"
];
?>

<!DOCTYPE html>
<html>
<head>

<title>Fraud Detection</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container py-5">

    <h2 class="mb-4">Fraud Detection</h2>

    <?php foreach($suspiciousUsers as $fraud): ?>

        <div class="alert alert-danger">

            <?= $fraud ?>

        </div>

    <?php endforeach; ?>

</div>

</body>
</html>