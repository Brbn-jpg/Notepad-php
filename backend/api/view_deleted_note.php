<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, OPTIONS");
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
    echo json_encode(["error" => "Nieautoryzowany dostęp"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$note_id = $_GET['id'] ?? 0;

if (!is_numeric($note_id)) {
    echo json_encode(["error" => "Nieprawidłowe ID notatki"]);
    exit;
}

$stmt = $con->prepare("SELECT id, title, content, changed_at FROM history WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $note_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Notatka nie została znaleziona"]);
    exit;
}

$note = $result->fetch_assoc();
echo json_encode($note);
