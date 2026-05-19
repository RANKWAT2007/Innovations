<?php
require '../config/db.php';

if(isset($_POST['name'])){

    $name = $_POST['name'];

    $stmt = $pdo->prepare("INSERT INTO departments(name) VALUES(?)");
    $stmt->execute([$name]);

    echo "<script>alert('Department Added Successfully');window.location='departments.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Department</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#F8FAFC;
    font-family:Poppins;
}

.navbar{
    background:#0F766E;
}

.card-box{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    max-width:500px;
    margin:auto;
}

.input{
    border-radius:12px;
    padding:12px;
    width:100%;
    border:1px solid #ddd;
}

.btn-custom{
    background:#0F766E;
    color:white;
    padding:12px;
    border:none;
    border-radius:12px;
    width:100%;
}

.btn-custom:hover{
    background:#14B8A6;
}

</style>

</head>

<body>

<nav class="navbar navbar-dark px-4">
    <a class="navbar-brand">Add Department</a>
</nav>

<div class="container py-5">

<div class="card-box">

<h3 class="mb-3">Create New Department</h3>

<form method="POST">

<input type="text" name="name"
class="input mb-3"
placeholder="Enter Department Name" required>

<button class="btn-custom">
Add Department
</button>

</form>

</div>

</div>

</body>
</html>