<?php
// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Get the HTTP request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Define the file to include based on the request method
switch ($requestMethod) {
    case 'GET':
        $pageURL = 'pages/api/methods/get.php';
        break;
    case 'POST':
        $pageURL = 'pages/api/methods/post.php';
        break;
    case 'DELETE':
        $pageURL = 'pages/api/methods/delete.php';
        break;
    case 'PUT':
        $pageURL = 'pages/api/methods/put.php';
        break;
    case 'OPTIONS':
        // Handle preflight request
        header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Origin: *');
        exit; // No further processing required for OPTIONS requests
    default:
        // Respond with a 405 Method Not Allowed if the method is unsupported
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        exit;
}

// Check if the file exists before including it
if (file_exists($pageURL)) {
    include($pageURL);
} else {
    // Respond with a 404 Not Found if the file does not exist
    http_response_code(404);
    echo json_encode(["error" => "File not found: $pageURL"]);
}

// Exit to ensure no additional output is sent
exit;
?>