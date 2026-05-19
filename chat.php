<?php
require '../config/db.php';
require '../config/session.php';

$receiver = 1;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO messages(sender_id,receiver_id,message)
    VALUES(?,?,?)");

    $stmt->execute([
        $_SESSION['user_id'],
        $receiver,
        $message
    ]);
}

$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at ASC");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>

<title>Chat</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container py-5">

    <div class="card p-4">

        <h3>Live Chat</h3>

        <div style="height:400px;overflow-y:auto;">

            <?php foreach($messages as $msg): ?>

                <div class="mb-3">

                    <strong>
                        User <?= $msg['sender_id'] ?>
                    </strong>

                    <p>
                        <?= $msg['message'] ?>
                    </p>

                </div>

            <?php endforeach; ?>

        </div>

        <form method="POST">

            <div class="input-group">

                <input
                    type="text"
                    name="message"
                    class="form-control"
                    placeholder="Type message..."
                >

                <button class="btn btn-success">
                    Send
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>