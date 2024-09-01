<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = $_POST['customer_name'] ?? '';
    $customerCountry = $_POST['customer_country'] ?? '';
    $customerPhone = $_POST['customer_phone'] ?? '';
    $customerRemarks = $_POST['customer_remarks'] ?? '';
    $userToken = $_SESSION['user_token'];

    // Validate input
    if (empty($customerName) || empty($customerCountry) || empty($customerPhone)) {
        header("Location: /crm-customer?status=error&error=201"); // Error code for missing required fields
        exit();
    }

    // Ensure phone number format and other validations are handled as required

    // Generate unique token
    $customerToken = md5(uniqid());

    // Format full phone number
    $fullPhone = $customerCountry . '' . $customerPhone;

    // Get logged-in user ID from session
    session_start();
    $userId = $_SESSION['user_id'] ?? 0;

    if ($userId == 0) {
        header("Location: /auth-login?status=error&error=202"); // Error code for session issue
        exit();
    }

    // Prepare SQL statement to insert new customer record
    $stmt = $pdo->prepare("INSERT INTO customers (token, date, time, stat, name, country, phone, full_phone, remark, is_whatsapp, is_business, user_id, user_token) VALUES (:token, :date, :time, :stat, :name, :country, :phone, :full_phone, :remark, :is_whatsapp, :is_business, :user_id, :user_token)");
    $stmt->execute([
        ':token' => $customerToken,
        ':date' => $Today,
        ':time' => $Time,
        ':stat' => 0, // Default status
        ':name' => $customerName,
        ':country' => $customerCountry,
        ':phone' => $customerPhone,
        ':full_phone' => $fullPhone,
        ':remark' => $customerRemarks,
        ':is_whatsapp' => 0, // Default value
        ':is_business' => 0, // Default value
        ':user_id' => $userId,
        ':user_token' => $userToken
    ]);

    // Redirect to dashboard or success page
    header("Location: /crm-customer?status=success");
    exit();
}
?>