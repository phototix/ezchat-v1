<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $agent_name = $_POST['agent_name'] ?? '';
    $agent_email = $_POST['agent_email'] ?? '';
    $userpassword = $_POST['userpassword'] ?? '';
    $confirmpassword = $_POST['confirmpassword'] ?? '';
    $agent_country = $_POST['agent_country'] ?? '';
    $agent_phone = $_POST['agent_phone'] ?? '';

    // Initialize error array
    $errors = [];

    // Validate each field
    if (empty($agent_name)) {
        $errors[] = 'Agent Name';
    }
    if (empty($agent_email)) {
        $errors[] = 'Agent Email';
    }
    if (empty($userpassword)) {
        $errors[] = 'Password';
    }
    if (empty($confirmpassword)) {
        $errors[] = 'Confirm Password';
    }
    if (empty($agent_country)) {
        $errors[] = 'Country';
    }
    if (empty($agent_phone)) {
        $errors[] = 'Phone';
    }

    // Check if there are validation errors
    if (!empty($errors)) {
        $errorMessage = implode(', ', $errors) . ' field(s) are required.';
        header("Location: /$page?status=error&error=201&message=" . urlencode($errorMessage));
        exit();
    }

    // Check if passwords match
    if ($userpassword !== $confirmpassword) {
        header("Location: /$page?status=error&error=204"); // Error code for password mismatch
        exit();
    }

    $userId = $_SESSION['user_id'] ?? 0;

    // Check if the email already exists
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute([':email' => $agent_email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Email already exists
            header("Location: /$page?status=error&error=202"); // Error code for existing email
            exit();
        } else {
            // Generate a unique salt
            $saltKey = md5(uniqid());
            
            // Encrypt the password using md5 with salt
            $encryptedPassword = md5($userpassword . "-webbycms-encrypt-1824-" . $saltKey);
            $fullPhone = $agent_country . '' . $agent_phone;
            $username = $agent_email;

            // Prepare SQL statement to insert the new agent
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, salt, token, date, time, stat, name, country, phone, full_phone, user_type, user_id, top) VALUES (:username, :email, :password, :salt, :token, :date, :time, '0', :name, :country, :phone, :full_phone, 'agent', :user_id, '')");
            $stmt->execute([
                ':username' => $username,
                ':email' => $agent_email,
                ':password' => $encryptedPassword,
                ':salt' => $saltKey,
                ':token' => md5(uniqid()), // Example token generation
                ':date' => date("Y-m-d"),
                ':time' => date("H:i:s"),
                ':name' => $agent_name,
                ':country' => $agent_country,
                ':phone' => $agent_phone,
                ':full_phone' => $fullPhone,
                ':user_id' => $userId
            ]);

            // Redirect to the same page with success status
            header("Location: /$page?status=success");
            exit();
        }
    } catch (PDOException $e) {
        // Log the error and redirect with an error code
        // Optionally, log $e->getMessage() to a file for debugging
        header("Location: /$page?status=error&error=203&message=" . urlencode($e->getMessage())); // Error code for database issue
        exit();
    }
}
?>
