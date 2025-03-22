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

// Rozpocznij transakcję
$con->autocommit(FALSE);

$query = "SELECT * FROM notes WHERE id = ? AND user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $note_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $note = $result->fetch_assoc();

    // Zapisz dane notatki do tabeli history
    $insert_query = "INSERT INTO history (user_id, note_id, title, content) VALUES (?, ?, ?, ?)";
    $insert_stmt = $con->prepare($insert_query);
    $insert_stmt->bind_param("iiss", $user_id, $note_id, $note['title'], $note['content']);
    if (!$insert_stmt->execute()) {
        $con->rollback(); // Wycofaj transakcję w przypadku błędu
        die("Błąd podczas zapisywania do tabeli history: " . $insert_stmt->error);
    } else {
        echo "Notatka została zapisana w historii.<br>";
    }

    // Usuń notatkę z tabeli notes
    $delete_query = "DELETE FROM notes WHERE id = ? AND user_id = ?";
    $delete_stmt = $con->prepare($delete_query);
    $delete_stmt->bind_param("ii", $note_id, $user_id);

    if ($delete_stmt->execute()) {
        echo "Notatka została usunięta z tabeli notes.<br>";
    } else {
        $con->rollback(); // Wycofaj transakcję w przypadku błędu
        die("Błąd podczas usuwania notatki: " . $delete_stmt->error);
    }
} else {
    $con->rollback(); // Wycofaj transakcję w przypadku błędu
    die("Nie znaleziono notatki o podanym ID.");
}

// Zatwierdź transakcję
$con->commit();
$con->autocommit(TRUE); // Przywróć automatyczne zatwierdzanie

echo "Operacja zakończona pomyślnie.";
?>