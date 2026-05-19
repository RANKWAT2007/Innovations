<?php
require '../config/db.php';
require '../config/session.php';

header('Content-Type: application/json');

$item = $_POST['item_name'];
$category = $_POST['category'];

$stmt = $pdo->prepare("INSERT INTO found_items(user_id,item_name,category)
VALUES(?,?,?)");

$stmt->execute([
    $_SESSION['user_id'],
    $item,
    $category
]);

echo json_encode([
    "status" => "success",
    "message" => "Found Item Added"
]);
?>