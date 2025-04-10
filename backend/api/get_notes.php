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

if ($con->connect_error) {
  $debug["db_error"] = $con->connect_error;
  echo json_encode(["error" => "Błąd połączenia z bazą"]);
  exit;
}

$user_data = check_login($con);
$debug["is_logged_in"] = ($user_data !== null);
$debug["user_data"] = $user_data;

if (!$user_data) {
    echo json_encode(["notes" => [], "message" => "Użytkownik nie jest zalogowany"]);
    exit;
}

$user_id = $user_data['id'];
$query = "SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();


$notes = [];
while ($result && $row = $result->fetch_assoc()) {
    $notes[] = $row;
}

echo json_encode(["notes" => $notes]);
exit;
?>