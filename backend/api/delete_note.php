<?php
session_start();
include("../connection.php");
include("../functions.php");

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$user_data = check_login($con);
$user_id = $user_data['id'];

$data = json_decode(file_get_contents("php://input"), true);
$note_id = $data['note_id'] ?? 0;

if (!is_numeric($note_id) || $note_id <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid note ID"]);
    exit;
}

$con->autocommit(FALSE); 

try {
    $select_stmt = $con->prepare("SELECT title, content FROM notes WHERE id = ? AND user_id = ?");
    $select_stmt->bind_param("ii", $note_id, $user_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Notatka nie istnieje lub nie należy do użytkownika.");
    }

    $note = $result->fetch_assoc();

    $insert_stmt = $con->prepare("INSERT INTO history (user_id, note_id, title, content) VALUES (?, ?, ?, ?)");
    $insert_stmt->bind_param("iiss", $user_id, $note_id, $note['title'], $note['content']);

    if (!$insert_stmt->execute()) {
        throw new Exception("Nie udało się zapisać do historii: " . $insert_stmt->error);
    }

    $delete_stmt = $con->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
    $delete_stmt->bind_param("ii", $note_id, $user_id);

    if (!$delete_stmt->execute()) {
        throw new Exception("Nie udało się usunąć notatki: " . $delete_stmt->error);
    }

    // 4. Commit
    $con->commit();
    $con->autocommit(TRUE);

    echo json_encode(["success" => true]);

} catch (Exception $e) {
    $con->rollback();
    $con->autocommit(TRUE);
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
