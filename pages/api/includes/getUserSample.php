<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: /auth-login");
    exit();
}
checkAdminAccess();

$stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$userId = $user['username'];
// Example data to be returned as JSON
$responseData = [
    "status" => "success",
    "message" => "Data retrieved successfully",
    "data" => [
        "id" => $_SESSION['user_id'],
        "name" => "Current Logged Username: ".$userId,
        "username" => $userId
    ]
];
// Return the JSON-encoded response
echo json_encode($responseData);