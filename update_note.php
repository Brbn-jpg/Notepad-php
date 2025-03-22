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
    $note_id = $_POST['note_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $user_data['id'];

    if (!empty($title) && !empty($content)) {
        $stmt = $con->prepare("UPDATE notes SET title = ?, content = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $title, $content, $note_id, $user_id);

        if ($stmt->execute()) {
            header("Location: notes.php");
            exit;
        } else {
            echo "Wystąpił błąd podczas aktualizacji notatki.";
        }
    } else {
        echo "Proszę wypełnić wszystkie pola.";
    }
}
?>