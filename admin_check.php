<?php

require_once '../config/session.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){

    die("Access Denied");
}
?>