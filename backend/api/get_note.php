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
    echo json_encode(["error" => "Użytkownik nie jest zalogowany"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$note_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($note_id <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Nieprawidłowe ID notatki"]);
    exit;
}

$query = "SELECT * FROM notes WHERE id = ? AND user_id = ? LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $note_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $note = $result->fetch_assoc();
    echo json_encode($note);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Notatka nie została znaleziona"]);
}
exit;
?>