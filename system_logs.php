<?php
$logs = [
    "User login successful",
    "Item reported",
    "Admin approved claim",
    "Password changed"
];
?>

<!DOCTYPE html>
<html>
<head>

<title>System Logs</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container py-5">

    <h2 class="mb-4">System Logs</h2>

    <ul class="list-group">

        <?php foreach($logs as $log): ?>

            <li class="list-group-item">

                <?= $log ?>

            </li>

        <?php endforeach; ?>

    </ul>

</div>

</body>
</html>