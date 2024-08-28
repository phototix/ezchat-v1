<?php
// Check if form and action are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form']) && isset($_POST['action']) && isset($_POST['csrf_token'])) {
    $formToken = $_POST['form'];
    $action = $_POST['action'];
    $csrfToken = $_POST['csrf_token'];

    // Verify CSRF token
    if (!verifyCsrfToken($csrfToken)) {
        die("Error: Invalid CSRF token.");
    }

    // Sanitize and validate input
    $allowedActions = ['user_register', 'user_password_recovery', 'user_verify_otp', 'user_reset_password', 'user_login']; // Add more actions as needed
    if (in_array($action, $allowedActions)) {
        $actionFile = WEBBY_ROOT . "/controller/forms/{$action}.php";

        // Check if the action file exists
        if (file_exists($actionFile)) {
            // Include the action file
            include $actionFile;

            // Redirect to a success page after processing
            header("Location: /?status=success");
            exit();
        } else {
            echo "Error: Action file not found.";
        }
    } else {
        echo "Error: Invalid action specified.";
    }
}
?>
