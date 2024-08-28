<?php
// Include your database connection
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $otp = $_POST['otp'] ?? '';
    $page = $_POST['page'] ?? 'otp-verification'; // Retrieve the current page from the form

    // Validate input
    if (empty($email) || empty($otp)) {
        header("Location: /$page?status=error&error=301"); // Error code 301 for missing email or OTP
        exit();
    } else {
        // Verify OTP
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND otp = :otp AND otp_expiration > NOW()");
            $stmt->execute([':email' => $email, ':otp' => $otp]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // OTP verified, redirect to password reset page
                header("Location: /auth-reset-password?email=" . urlencode($email));
                exit();
            } else {
                header("Location: /$page?status=error&error=302"); // Error code 302 for invalid OTP or expired OTP
                exit();
            }
        } catch (PDOException $e) {
            // Log the error and redirect with an error code
            // Optionally, log $e->getMessage() to a file for debugging
            header("Location: /$page?status=error&error=303"); // Error code 303 for database error
            exit();
        }
    }
}
?>
