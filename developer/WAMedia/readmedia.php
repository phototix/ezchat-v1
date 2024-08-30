<?php
include '../../controller/conn.php';

// Define the file URL and API key
$fileUrl = $WAHAApiUrl.$_GET["url"];
$apiKey = '8cd0de4e14cd240a97209625af4bdeb0';

// Initialize cURL session
$ch = curl_init($fileUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-Api-Key: ' . $apiKey, // Set the API key in the header
]);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpStatusCode == 200) {
        // Successfully retrieved the file
        echo $response;
    } else {
        // Handle error responses
        echo 'Error: ' . $response . ' (HTTP Status Code: ' . $httpStatusCode . ')';
    }
}

// Close cURL session
curl_close($ch);
?>