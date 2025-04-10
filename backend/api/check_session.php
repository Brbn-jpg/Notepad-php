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

$user_data = null;
if (isset($_SESSION['user_id'])) {
    $user_data = check_login($con);
}

$response = array(
    "logged_in" => ($user_data !== null),
    "user_id" => ($user_data !== null) ? $user_data['id'] : null
);

echo json_encode($response);
exit;
?>