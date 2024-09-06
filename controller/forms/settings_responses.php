<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preset_pending = $_POST['preset_pending'];
    $isSendByEnter="";
    if($isSendByEnter==""){ $isSendByEnter=0; }else{ $isSendByEnter=1; }
    if($preset_pending==""){ $preset_pending='Hi <name>, please wait. Our agent will attending you in a while!'; }
    $page = $_POST['page']; // Retrieve the current page from the form
    $userID = $_SESSION['user_id'];

    // Prepare the SQL update statement
    $sql = "UPDATE users SET preset_pending = :preset_pending WHERE id = :id";

    try {
        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':preset_pending', $preset_pending);
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
