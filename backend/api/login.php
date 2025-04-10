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

$response = ["success" => false, "error" => null];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $user_name = $data['login'] ?? "";
    $password = $data['password'] ?? "";

    if (empty($user_name) || empty($password)) {
        $response["error"] = "Proszę wypełnić wszystkie pola.";
    } else {
        $stmt = $con->prepare("SELECT * FROM users WHERE user_name = ? LIMIT 1");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['id'];
                $response["success"] = true;
            } else {
                $response["error"] = "Błędne hasło.";
            }
        } else {
            $response["error"] = "Nie znaleziono użytkownika o podanym loginie.";
        }
    }
}

echo json_encode($response);
exit;
