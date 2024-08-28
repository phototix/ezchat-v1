<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $page = $_POST['page'] ?? 'password-recovery'; // Retrieve the current page from the form

    // Validate email
    if (empty($email)) {
        header("Location: /$page?status=error&error=201"); // Error code 201 for missing email
        exit();
    } else {
        // Check if the email exists in the database
        try {
            $stmt = $pdo->prepare("SELECT id, phone FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Generate OTP
                $otp = rand(100000, 999999);
                $userId = $user['id'];
                $phone = $user['phone'];

                // Save OTP to database with expiration time
                $stmt = $pdo->prepare("UPDATE users SET otp = :otp, otp_expiration = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE id = :id");
                $stmt->execute([':otp' => $otp, ':id' => $userId]);

                // Send OTP to WhatsApp API
                $apiUrl = 'https://api.whatsapp.com/send'; // Replace with your WhatsApp API URL
                $apiToken = 'YOUR_API_TOKEN'; // Replace with your API token
                $message = "Your OTP for password recovery is: $otp";
                
                $data = [
                    'phone' => $phone,
                    'message' => $message,
                    'token' => $apiToken
                ];

                // Make API request (simplified, use cURL or other methods in production)
                $response = true; // Simulate API response; replace with actual API call

                if ($response) {
                    // Redirect to OTP verification
                    header("Location: /auth-verify?email=" . urlencode($email));
                    exit();
                } else {
                    header("Location: /$page?status=error&error=203"); // Error code 203 for failed OTP sending
                    exit();
                }
            } else {
                header("Location: /$page?status=error&error=202"); // Error code 202 for email not found
                exit();
            }
        } catch (PDOException $e) {
            // Log the error and redirect with an error code
            // Optionally, log $e->getMessage() to a file for debugging
            header("Location: /$page?status=error&error=204"); // Error code 204 for database error
            exit();
        }
    }
}
?>