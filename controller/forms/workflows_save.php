<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flowchart_data = $_POST['flowchart_data'];
    $page = $_POST['page']; // Retrieve the current page from the form
    $userID = $_SESSION['user_id'];

    // Prepare the SQL update statement
    $sql = "UPDATE users SET workflows = :workflows WHERE id = :id";

    try {
        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':workflows', $flowchart_data);
        $stmt->bindParam(':id', $userID);

        // Execute the statement
        $stmt->execute();

        header("Location: /$page?status=success");
    } catch (PDOException $e) {
        header("Location: /$page?status=error&token=$token&error=104");
    }
    exit();
           
}
?>
