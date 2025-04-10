<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

session_start();
include("../connection.php");
include("../functions.php");

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$json = file_get_contents("php://input");
$data = json_decode($json, true);

error_log("Received data in update_note.php: " . print_r($data, true));

$note_id = isset($data['id']) ? $data['id'] : (isset($data['note_id']) ? $data['note_id'] : 0);
$title = isset($data['title']) ? $data['title'] : '';
$content = isset($data['content']) ? $data['content'] : '';

if (empty($title) || empty($content) || empty($note_id)) {
    http_response_code(400);
    echo json_encode([
        "error" => "Invalid input", 
        "received" => [
            "note_id" => $note_id,
            "title" => $title,
            "content" => $content
        ]
    ]);
    exit;
}

$stmt = $con->prepare("UPDATE notes SET title = ?, content = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
$stmt->bind_param("ssii", $title, $content, $note_id, $user_id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true, 
        "message" => "Notatka została zaktualizowana"
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "error" => "Failed to update note", 
        "db_error" => $con->error
    ]);
}
?>