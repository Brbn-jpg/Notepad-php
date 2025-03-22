<?php
session_start();
include("connection.php"); 
include("functions.php"); 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

$user_data = check_login($con);
if (!isset($_GET['id'])) {
    header("Location: notes.php"); 
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
    header("Location: notes.php"); 
    exit;
}

$note = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php include 'modules/nav-logged.php'; ?>
    <section class="view-note-section">
      <h2><?php echo htmlspecialchars($note['title']); ?></h2>
      <p class="note-content"><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
      <div class="note-meta">
        <p><strong>Utworzono:</strong> <?php echo $note['created_at']; ?></p>
        <p><strong>Ostatnia aktualizacja:</strong> <?php echo $note['updated_at']; ?></p>
      </div>
      <div class="actions">
        <a href="edit.php?id=<?php echo $note['id']; ?>" class="view-btn">Edytuj</a>
        <a href="delete.php?id=<?php echo $note['id']; ?>" class="view-btn" onclick="return confirm('Czy na pewno chcesz usunąć tę notatkę?');">Usuń</a>
        <a href="notes.php" class="view-btn">Powrót do listy notatek</a>
      </div>
    </section>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>