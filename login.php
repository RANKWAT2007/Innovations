<?php
require 'config/db.php';
require 'config/session.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {

        $error = "Please fill all fields";

    } else {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Invalid Email or Password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | CampuRecover</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>

        body{
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #0F766E, #14B8A6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card{
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            border-radius: 25px;
            padding: 45px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            color: white;
        }

        .login-title{
            font-weight: 700;
            font-size: 2.3rem;
        }

        .form-control{
            height: 50px;
            border-radius: 12px;
            border: none;
        }

        .form-control:focus{
            box-shadow: 0 0 10px rgba(255,255,255,0.5);
        }

        .btn-login{
            background: #FDFCF8;
            color: #0F766E;
            font-weight: 600;
            height: 50px;
            border-radius: 12px;
            transition: 0.3s ease;
        }

        .btn-login:hover{
            background: #F5F1E8;
            transform: translateY(-2px);
        }

        .login-image{
            width: 100%;
            max-width: 420px;
        }

        .small-text{
            color: #FDFCF8;
        }

        .small-text a{
            color: white;
            font-weight: 600;
            text-decoration: none;
        }

        .small-text a:hover{
            text-decoration: underline;
        }

    </style>

</head>
<body>

<div class="container">

    <div class="row align-items-center justify-content-center">

        <!-- Left Side -->
        <div class="col-lg-5 d-none d-lg-block text-center">

            <img 
                src="image1.jpg" 
                alt="Login Illustration"
                class="login-image"
                height="400"
                width="600"
            >

        </div>

        <!-- Right Side -->
        <div class="col-lg-5 col-md-8">

            <div class="login-card">

                <div class="text-center mb-4">

                    <h1 class="login-title">CampuRecover</h1>

                    <p class="mt-2">
                        Smart Lost & Found Portal
                    </p>

                </div>

                <!-- Error Alert -->
                <?php if($error): ?>

                    <div class="alert alert-danger text-center">
                        <?= $error ?>
                    </div>

                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST">

                    <!-- Email -->
                    <div class="mb-3">

                        <label class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter your email"
                            required
                        >

                    </div>

                    <!-- Password -->
                    <div class="mb-4">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            required
                        >

                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-login w-100">

                        Login

                    </button>

                </form>

                <!-- Register -->
                <div class="text-center mt-4 small-text">

                    Don't have an account?

                    <a href="register.php">
                        Register Here
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>