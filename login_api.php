<?php
require '../config/db.php';
require '../config/session.php';

header('Content-Type: application/json');

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
$stmt->execute([$email]);

$user = $stmt->fetch();

if($user && password_verify($password, $user['password'])){

    $_SESSION['user_id'] = $user['id'];

    echo json_encode([
        "status" => "success",
        "message" => "Login Successful"
    ]);

}else{

    echo json_encode([
        "status" => "error",
        "message" => "Invalid Credentials"
    ]);
}
?>