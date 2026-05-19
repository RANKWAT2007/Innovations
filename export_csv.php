<?php
require '../config/db.php';

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=claims_report.csv");

$output = fopen("php://output", "w");

fputcsv($output, ["ID","User ID","Item ID","Status","Date"]);

$stmt = $pdo->query("SELECT * FROM claims ORDER BY id DESC");

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    fputcsv($output, $row);
}

fclose($output);
exit;
?>