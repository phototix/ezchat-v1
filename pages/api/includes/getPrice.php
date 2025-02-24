<?php
// Example data to be returned as JSON
$responseData = [
    "status" => "success",
    "message" => "Data retrieved successfully",
    "data" => [
        "id" => 123,
        "name" => "Example Item",
        "price" => 49.99
    ]
];
// Return the JSON-encoded response
echo json_encode($responseData);