<?php
require '../config/db.php';

if(!isset($_GET['id'])){
    die("Invalid Request");
}

$id = $_GET['id'];

/*
========================
UPDATE STATUS
========================
*/

$stmt = $pdo->prepare("
UPDATE claims
SET status='Approved'
WHERE id=?
");

$stmt->execute([$id]);

/*
========================
REDIRECT BACK
========================
*/

header("Location: manage_claims.php");
exit;
?>