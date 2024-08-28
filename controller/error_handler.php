<?php
// Define error messages
$errorMessages = [
    '100' => 'Unauthorized access.',
    '101' => 'Username and email are required.',
    '102' => 'Username already taken.',
    '103' => 'An error occurred while processing your request.',
    '104' => 'Passwords do not match.',
    '201' => 'Email is required.',
    '202' => 'Email not found in the database.',
    '203' => 'Failed to send OTP.',
    '204' => 'Database error',
    '301' => 'Email and OTP are required.',
    '302' => 'Invalid OTP or OTP expired.',
    '303' => 'Database error',
    '401' => 'Missing fields (email, password, or confirm password).',
    '402' => 'Passwords do not match.',
    '403' => 'Database error',
    '501' => 'Missing email or password.',
    '502' => 'Incorrect password.',
    '503' => 'Email not found.',
    '504' => 'Database error',
];

if(isset($error)){
    $errorCode = $error;    
}

// Handle status and error codes
switch ($status) {
    case 'success':
        echo '<div class="alert alert-primary">';
        echo "<h1>Success</h1>";
        echo "<p>Your action was completed successfully.</p>";
        echo '</div>';
        break;
    case 'error':
        if (array_key_exists($errorCode, $errorMessages)) {
            echo '<div class="alert alert-warning">';
            echo "<h1>Error</h1>";
            echo "<p>{$errorMessages[$errorCode]}</p>";
            echo '</div>';
        } else {
            echo '<div class="alert alert-warning">';
            echo "<h1>Error</h1>";
            echo "<p>An unknown error occurred.</p>";
            echo '</div>';
        }
        break;
    default:
        echo '<div class="alert alert-primary">';
        echo "<h1>Welcome</h1>";
        echo "<p>Welcome to the application.</p>";
        echo '</div>';
        break;
}
?>