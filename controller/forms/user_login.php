<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $page = $_POST['page'] ?? 'user_login'; // Retrieve the current page from the form

    // Validate input
    if (empty($email) || empty($password)) {
        header("Location: /$page?status=error&error=501"); // Error code 501 for missing email or password
        exit();
    } else {
        try {
            // Fetch user details from the database
            $stmt = $pdo->prepare("SELECT id, password, salt, username, user_type FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password
                $saltKey = $user['salt'];
                $encryptedPassword = md5($password . "-webbycms-encrypt-1824-" . $saltKey);

                if ($encryptedPassword === $user['password']) {
                    // Password is correct, login successful
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_type'] = $user['user_type'];
                    $_SESSION['user_token'] = $user['username'];

                    $userId = $user['username'];
                    $apiKey = '8cd0de4e14cd240a97209625af4bdeb0'; // Replace with your actual API key
                    $qrApiUrl = "https://server01.ezy.chat/api/screenshot?session=".$userId;
                    $statusApiUrl = "https://server01.ezy.chat/api/sessions/$userId";

                    $status = checkWhatsappStatus($statusApiUrl, $apiKey);

                    if ($status === 'WORKING') {
                        $stmt = $pdo->prepare("UPDATE users SET whatsapp_connected = 1 WHERE id = :id");
                        $stmt->execute([':id' => $_SESSION['user_id']]);
                    } elseif ($status === 'SCAN_QR_CODE' || $status === 'FAILED' || $status === 'STOPPED') {
                        $stmt = $pdo->prepare("UPDATE users SET whatsapp_connected = 2 WHERE id = :id");
                        $stmt->execute([':id' => $_SESSION['user_id']]);
                    } else {
                        $stmt = $pdo->prepare("UPDATE users SET whatsapp_connected = 0 WHERE id = :id");
                        $stmt->execute([':id' => $_SESSION['user_id']]);
                    }

                    header("Location: /dashboard?status=success");
                    exit();
                } else {
                    header("Location: /$page?status=error&error=502"); // Error code 502 for incorrect password
                    exit();
                }
            } else {
                header("Location: /$page?status=error&error=503"); // Error code 503 for email not found
                exit();
            }
        } catch (PDOException $e) {
            // Log the error and redirect with an error code
            // Optionally, log $e->getMessage() to a file for debugging
            header("Location: /$page?status=error&error=504"); // Error code 504 for database error
            exit();
        }
    }
}
?>
