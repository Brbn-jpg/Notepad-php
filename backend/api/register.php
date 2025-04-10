<?php
session_start();
include("../connection.php");

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:8080"); 
header("Access-Control-Allow-Methods: POST, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Access-Control-Allow-Credentials: true"); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$user_name = $data['login'] ?? '';
$password = $data['password'] ?? '';
$repeatedPassword = $data['repeatedPassword'] ?? '';

if (empty($user_name) || empty($password) || empty($repeatedPassword)) {
    http_response_code(400);
    echo json_encode(["error" => "Proszę wypełnić wszystkie pola."]);
    exit;
}

if ($password !== $repeatedPassword) {
    http_response_code(400);
    echo json_encode(["error" => "Hasła się nie zgadzają! Proszę spróbować ponownie."]);
    exit;
}

$stmt = $con->prepare("SELECT * FROM users WHERE user_name = ? LIMIT 1");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Błąd zapytania do bazy danych: " . $con->error]);
    exit;
}
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["error" => "Użytkownik o takim loginie już istnieje."]);
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $con->prepare("INSERT INTO users (user_name, password) VALUES (?, ?)");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Błąd zapytania do bazy danych: " . $con->error]);
    exit;
}
$stmt->bind_param("ss", $user_name, $hashed_password);

if ($stmt->execute()) {
    http_response_code(201); 
    echo json_encode(["success" => "Rejestracja zakończona sukcesem!"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Wystąpił błąd podczas rejestracji: " . $stmt->error]);
}

?>