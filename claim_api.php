<?php
require '../config/db.php';
require '../config/session.php';

header('Content-Type: application/json');

$item_id = $_POST['item_id'];

$stmt = $pdo->prepare("INSERT INTO claims(user_id,item_id,status)
VALUES(?,?,?)");

$stmt->execute([
    $_SESSION['user_id'],
    $item_id,
    "Pending"
]);

echo json_encode([
    "status" => "success",
    "message" => "Claim Submitted"
]);
?>