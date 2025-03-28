<?php
session_start();
include("connection.php"); 
include("functions.php"); 

if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, aby usunąć notatkę.");
}

$user_data = check_login($con);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Nieprawidłowe ID notatki.");
}

$note_id = $_GET['id'];
$user_id = $user_data['id'];

if (!$con) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}

$con->autocommit(FALSE);

$query = "SELECT * FROM notes WHERE id = ? AND user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $note_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $note = $result->fetch_assoc();

    $insert_query = "INSERT INTO history (user_id, note_id, title, content) VALUES (?, ?, ?, ?)";
    $insert_stmt = $con->prepare($insert_query);
    $insert_stmt->bind_param("iiss", $user_id, $note_id, $note['title'], $note['content']);
    if (!$insert_stmt->execute()) {
        $con->rollback(); 
        die("Błąd podczas zapisywania do tabeli history: " . $insert_stmt->error);
    }

    $delete_query = "DELETE FROM notes WHERE id = ? AND user_id = ?";
    $delete_stmt = $con->prepare($delete_query);
    $delete_stmt->bind_param("ii", $note_id, $user_id);

    if (!$delete_stmt->execute()) {
        $con->rollback(); 
        die("Błąd podczas usuwania notatki: " . $delete_stmt->error);
    }
} else {
    $con->rollback(); 
    die("Nie znaleziono notatki o podanym ID.");
}

$con->commit();
$con->autocommit(TRUE); 

header("Location: notes.php");
exit;
?>