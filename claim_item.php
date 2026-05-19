<?php

require '../config/db.php';
require '../config/session.php';

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id'])){

    die("Invalid Item ID");
}

$item_id = $_GET['id'];

/*
========================================
CHECK ITEM EXISTS
========================================
*/

$itemCheck = $pdo->prepare("
SELECT * FROM found_items
WHERE id=?
");

$itemCheck->execute([$item_id]);

$item = $itemCheck->fetch();

if(!$item){

    die("Item not found");
}

/*
========================================
CHECK DUPLICATE CLAIM
========================================
*/

$check = $pdo->prepare("
SELECT * FROM claims
WHERE user_id=? AND item_id=?
");

$check->execute([$user_id,$item_id]);

if($check->rowCount() > 0){

    echo "

    <script>

        alert('You already claimed this item.');

        window.location.href='my_claims.php';

    </script>

    ";

    exit;
}

/*
========================================
INSERT CLAIM
========================================
*/

$stmt = $pdo->prepare("
INSERT INTO claims(
user_id,
item_id,
status
)

VALUES(
?,?,?
)
");

$stmt->execute([
    $user_id,
    $item_id,
    'Pending'
]);

/*
========================================
NOTIFICATION INSERT
========================================
*/

$message = "Your claim request has been submitted successfully.";

$notify = $pdo->prepare("
INSERT INTO notifications(
user_id,
message
)

VALUES(
?,?
)
");

$notify->execute([
    $user_id,
    $message
]);

/*
========================================
SUCCESS REDIRECT
========================================
*/

echo "

<script>

    alert('Claim Submitted Successfully');

    window.location.href='my_claims.php';

</script>

";

?>