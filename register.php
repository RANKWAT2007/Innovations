<?php

require 'config/db.php';

$message = "";
$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $check->execute([$email]);

    if($check->rowCount() > 0){

        $error = "Email already exists";

    } else {

        $stmt = $pdo->prepare("INSERT INTO users(name,email,password)
        VALUES(?,?,?)");

        $stmt->execute([$name,$email,$password]);

        $message = "Registration Successful";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | CampuRecover</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="card card-custom p-5">

                <h1 class="text-center mb-4">
                    Create Account
                </h1>

                <?php if($message): ?>

                    <div class="alert alert-success">
                        <?= $message ?>
                    </div>

                <?php endif; ?>

                <?php if($error): ?>

                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">

                        <label>Name</label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-4">

                        <label>Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                        >

                    </div>

                    <button class="btn btn-teal w-100">
                        Register
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>