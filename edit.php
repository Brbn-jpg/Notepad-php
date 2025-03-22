<?php
session_start();
include("connection.php"); // Updated path
include("functions.php"); // Updated path

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Updated path
    exit;
}

$user_data = check_login($con);

if (!isset($_GET['id'])) {
    header("Location: notes.php"); // Updated path
    exit;
}

$note_id = $_GET['id'];
$user_id = $user_data['id'];

$query = "SELECT * FROM notes WHERE id = ? AND user_id = ? LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bind_param("ii", $note_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: notes.php"); // Updated path
    exit;
}

$note = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php include 'modules/nav-logged.php'; ?>
    <section class="add-note-section">
      <h2>Edytuj notatkę</h2>
      <form method="POST" action="update_note.php"> <!-- Updated path -->
        <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
        
        <label for="title" class="note-label">Tytuł notatki</label>
        <input
          type="text"
          name="title"
          class="note-title-input"
          required
          placeholder="Wprowadź tytuł notatki"
          value="<?php echo htmlspecialchars($note['title']); ?>"
        />

        <label class="note-label" for="content">Treść notatki</label>
        <textarea
          name="content"
          class="note-content"
          required
          placeholder="Wprowadź treść notatki"
        ><?php echo htmlspecialchars($note['content']); ?></textarea>

        <button type="submit" class="submit-btn">Zapisz zmiany</button>
      </form>
    </section>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>