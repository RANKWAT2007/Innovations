<?php
require '../config/db.php';

header('Content-Type: application/json');

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users(name,email,password)
VALUES(?,?,?)");

$stmt->execute([$name,$email,$password]);

echo json_encode([
    "status" => "success",
    "message" => "Registration Successful"
]);
?>