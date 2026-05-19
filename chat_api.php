<?php
require '../config/db.php';
require '../config/session.php';

header('Content-Type: application/json');

$message = $_POST['message'];

$stmt = $pdo->prepare("INSERT INTO messages(sender_id,message)
VALUES(?,?)");

$stmt->execute([
    $_SESSION['user_id'],
    $message
]);

echo json_encode([
    "status" => "success",
    "message" => "Message Sent"
]);
?>