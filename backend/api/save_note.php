<?php
header("Content-Type: application/json");
session_start();
include("../connection.php");
include("../functions.php");

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$user_data = check_login($con);
$user_id = $user_data['id'];

$data = json_decode(file_get_contents("php://input"), true);
$title = $data['title'] ?? '';
$content = $data['content'] ?? '';

if (!empty($title) && !empty($content)) {
    $stmt = $con->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to save note"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
}
?>