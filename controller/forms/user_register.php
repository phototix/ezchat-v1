<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $page = $_POST['page']; // Retrieve the current page from the form

    // Perform validation and sanitization as necessary
    if (empty($username) || empty($email) || empty($password) || empty($confirmpassword) || empty($phone) || empty($country)) {
        header("Location: /$page?status=error&error=101");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmpassword) {
        header("Location: /$page?status=error&error=104"); // New error code for password mismatch
        exit();
    }

    // Check if the username or email already exists
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
        $stmt->execute([':username' => $username, ':email' => $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Username or email already exists
            header("Location: /$page?status=error&error=102");
            exit();
        } else {
            // Generate a unique salt
            $saltKey = md5(uniqid());
            
            // Encrypt the password using md5 with salt
            $encryptedPassword = md5($password . "-webbycms-encrypt-1824-" . $saltKey);
            
            // Prepare SQL statement to insert the new user
            $fullPhone = $country . $phone; // Combine country code and phone number
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, salt, token, stat, date, time, phone, country, full_phone) VALUES (:username, :email, :password, :salt, :token, '0', :date, :time, :phone, :country, :full_phone)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $encryptedPassword, // Store the encrypted password
                ':salt' => $saltKey, // Store the salt key
                ':token' => md5(uniqid()), // Example token generation
                ':date' => date("Y-m-d"),
                ':time' => date("H:i:s"),
                ':phone' => $phone,
                ':country' => $country,
                ':full_phone' => $fullPhone // Store the combined phone
            ]);

            // Redirect to the login page with success status
            header("Location: /auth-login?status=success");
            exit();
        }
    } catch (PDOException $e) {
        // Log the error and redirect with an error code
        // Optionally, log $e->getMessage() to a file for debugging
        header("Location: /$page?status=error&error=103");
        exit();
    }
}
?>
