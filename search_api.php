<?php
require '../config/db.php';

header('Content-Type: application/json');

$search = $_GET['search'];

$stmt = $pdo->prepare("SELECT * FROM found_items
WHERE item_name LIKE ?");

$stmt->execute(["%$search%"]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
?>