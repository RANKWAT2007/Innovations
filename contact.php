<?php

$message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $msg = $_POST['message'];

    $message = "Message Sent Successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact | CampuRecover</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card card-custom p-5">

                <h1 class="text-center mb-4">
                    Contact Us
                </h1>

                <?php if($message): ?>

                    <div class="alert alert-success">
                        <?= $message ?>
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

                    <div class="mb-3">

                        <label>Subject</label>

                        <input
                            type="text"
                            name="subject"
                            class="form-control"
                        >

                    </div>

                    <div class="mb-4">

                        <label>Message</label>

                        <textarea
                            name="message"
                            rows="5"
                            class="form-control"
                        ></textarea>

                    </div>

                    <button class="btn btn-teal w-100">
                        Send Message
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>