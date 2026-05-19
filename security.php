<?php

function cleanInput($data){

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

    return $data;
}

function validateImage($file){

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if(in_array($fileExt, $allowed)){

        return true;

    }else{

        return false;
    }
}

function generateToken(){

    return bin2hex(random_bytes(32));
}

function verifyCSRF($token){

    if(isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token){

        return true;
    }

    return false;
}
?>