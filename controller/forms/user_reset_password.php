<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmpassword = $_POST['confirmpassword'] ?? '';
    $page = $_POST['page'] ?? 'reset-password'; // Retrieve the current page from the form

    // Validate input
    if (empty($email) || empty($password) || empty($confirmpassword)) {
        header("Location: /$page?status=error&error=401"); // Error code 401 for missing fields
        exit();
    } else {
        // Check if passwords match
        if ($password !== $confirmpassword) {
            header("Location: /$page?status=error&error=402"); // Error code 402 for password mismatch
            exit();
        } else {
            try {
                // Generate a unique salt
                $saltKey = md5(uniqid());
                $encryptedPassword = md5($password . "-webbycms-encrypt-1824-" . $saltKey);

                // Update the password in the database
                $stmt = $pdo->prepare("UPDATE users SET password = :password, salt = :salt, otp = '', otp_expiration = '' WHERE email = :email");
                $stmt->execute([
                    ':password' => $encryptedPassword,
                    ':salt' => $saltKey,
                    ':email' => $email
                ]);

                // Redirect to login page or show success message
                header("Location: /auth-login?status=success");
                exit();
            } catch (PDOException $e) {
                // Log the error and redirect with an error code
                // Optionally, log $e->getMessage() to a file for debugging
                header("Location: /$page?status=error&error=403"); // Error code 403 for database error
                exit();
            }
        }
    }
}
?>
