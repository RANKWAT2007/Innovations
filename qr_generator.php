<?php
require '../config/session.php';

$qrData = "USER-ID-" . $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>

<title>QR Generator</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container py-5 text-center">

    <h2 class="mb-4">QR Generator</h2>

    <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?= $qrData ?>"
    >

    <p class="mt-4">
        Scan this QR for item identification.
    </p>

</div>

</body>
</html>