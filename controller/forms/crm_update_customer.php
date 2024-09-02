<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and sanitize form inputs
    $customer_name = htmlspecialchars(trim($_POST['customer_name']));
    $customer_phone = htmlspecialchars(trim($_POST['customer_phone']));
    $customer_country = htmlspecialchars(trim($_POST['customer_country']));
    $customer_remarks = htmlspecialchars(trim($_POST['customer_remarks']));
    $page = $_POST['page'];

    // Check required fields
    if (empty($customer_name) || empty($customer_phone) || empty($customer_country)) {
        header("Location: /$page?status=error&error=102");
        exit();
    }

    // Prepare the full phone number
    $full_phone = $customer_country . $customer_phone;

    // Prepare the SQL update statement
    $sql = "UPDATE customers SET 
                name = :name, 
                country = :country, 
                phone = :phone, 
                full_phone = :full_phone, 
                remark = :remark, 
                date = CURDATE(), 
                time = CURTIME(), 
                stat = 1 
            WHERE token = :token";

    try {
        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $customer_name);
        $stmt->bindParam(':country', $customer_country);
        $stmt->bindParam(':phone', $customer_phone);
        $stmt->bindParam(':full_phone', $full_phone);
        $stmt->bindParam(':remark', $customer_remarks);
        $stmt->bindParam(':token', $token, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Check if update was successful
        if ($stmt->rowCount() > 0) {
            header("Location: /$page?status=success&token=$token&message=Customer profile updated successfully");
        } else {
            header("Location: /$page?status=error&token=$token&error=103");
        }
    } catch (PDOException $e) {
        header("Location: /$page?status=error&token=$token&error=104");
    }
} else {
    header("Location: /$page?status=error&token=$token&error=105");
}
exit();
?>
