<?php
// Check if form and action are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token']) && isset($_POST['action'])) {
    $formToken = $_POST['token'];
    $action = $_POST['action'];
    $page = $_POST['page'];

    // Sanitize and validate input
    $allowedActions = ['user_register', 'user_password_recovery', 'user_verify_otp', 'user_reset_password', 'user_login', 'crm_add_customer', 'crm_add_agent', 'sendText']; // Add more actions as needed
    if (in_array($action, $allowedActions)) {
        $actionFile = WEBBY_ROOT . "/controller/forms/{$action}.php";

        // Check if the action file exists
        if (file_exists($actionFile)) {
            // Include the action file
            include $actionFile;
            exit();
        } else {
            echo "Error: Action file not found.";
            header("Location: /$page?status=error&error=502");
        }
    } else {
        echo "Error: Invalid action specified.";
        header("Location: /$page?status=error&error=502");
    }
}
?>
