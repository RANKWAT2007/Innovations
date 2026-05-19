<?php

header('Content-Type: application/json');

$notifications = [

    [
        "message" => "New Match Found"
    ],

    [
        "message" => "Claim Approved"
    ]
];

echo json_encode($notifications);
?>