<?php
session_start();
include("connection.php"); 
include("functions.php"); 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_data = check_login($con);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $user_data['id'];

    if (!empty($title) && !empty($content)) {
        $stmt = $con->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $content);

        if ($stmt->execute()) {
            header("Location: notes.php");
            exit;
        } else {
            echo "Wystąpił błąd podczas zapisywania notatki.";
        }
    } else {
        echo "Proszę wypełnić wszystkie pola.";
    }
}
?>