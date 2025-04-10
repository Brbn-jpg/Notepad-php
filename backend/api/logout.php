<?php

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

session_start();

header("Content-Type: application/json");

if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
    session_destroy();
    echo json_encode(["success" => "Wylogowano pomyślnie."]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Nie jesteś zalogowany."]);
}
?>