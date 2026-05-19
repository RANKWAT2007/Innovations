<?php
require '../config/db.php';
require '../config/session.php';

$message = "";

/* FETCH DEPARTMENTS */
$deptStmt = $pdo->query("SELECT * FROM departments");
$departments = $deptStmt->fetchAll();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $location_lost = $_POST['location_lost'];
    $date_lost = $_POST['date_lost'];
    $department_id = $_POST['department_id'];

    $image = $_FILES['item_image']['name'];
    $tmp = $_FILES['item_image']['tmp_name'];

    move_uploaded_file($tmp,"../assets/uploads/lost_items/".$image);

    $stmt = $pdo->prepare("
        INSERT INTO lost_items
        (user_id,item_name,category,description,location_lost,date_lost,item_image,department_id)
        VALUES(?,?,?,?,?,?,?,?)
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        $item_name,
        $category,
        $description,
        $location_lost,
        $date_lost,
        $image,
        $department_id
    ]);

    $message = "Lost Item Reported Successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Report Lost Item</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container py-5">

<div class="card p-5">

<h2 class="mb-4">Report Lost Item</h2>

<?php if($message): ?>
<div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="item_name" class="form-control mb-3" placeholder="Item Name" required>

<input type="text" name="category" class="form-control mb-3" placeholder="Category">

<textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>

<input type="text" name="location_lost" class="form-control mb-3" placeholder="Location Lost">

<input type="date" name="date_lost" class="form-control mb-3">

<!-- ⭐ DEPARTMENT DROPDOWN -->
<select name="department_id" class="form-control mb-3" required>

<option value="">Select Department</option>

<?php foreach($departments as $d): ?>
<option value="<?= $d['id'] ?>">
    <?= $d['name'] ?>
</option>
<?php endforeach; ?>

</select>

<input type="file" name="item_image" class="form-control mb-4">

<button class="btn btn-success w-100">Submit</button>

</form>

</div>

</div>

</body>
</html>