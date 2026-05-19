<?php
require '../config/db.php';

if(!isset($_GET['id'])){
    die("Invalid Request");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("
UPDATE claims
SET status='Rejected'
WHERE id=?
");

$stmt->execute([$id]);

header("Location: manage_claims.php");
exit;
?>