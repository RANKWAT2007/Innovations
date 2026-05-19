<?php

header('Content-Type: application/json');

$lost = $_POST['lost'];
$found = $_POST['found'];

similar_text($lost, $found, $percent);

echo json_encode([
    "similarity" => round($percent,2)
]);
?>