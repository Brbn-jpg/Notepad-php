<?php
session_start();
include("connection.php");
include("functions.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_data = check_login($con);
$user_id = $user_data['id'];

$query = "SELECT * FROM notes WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en" class="page-auto">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php include 'modules/nav-logged.php'; ?>
    <section class="notes-section">
      <h2 class='user-notes'>Twoje notatki</h2>
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($note = mysqli_fetch_assoc($result)): ?>
            <div class="note">
              <a href="view_note.php?id=<?php echo $note['id']; ?>" class="note-link">
                <h2 class="note-title"><?php echo htmlspecialchars($note['title']); ?></h2>
              </a>
                <div class="edit-delete">
                    <div class="container">
                        <a href="edit.php?id=<?php echo $note['id']; ?>" class="edit">Edytuj</a>
                        <a href="delete.php?id=<?php echo $note['id']; ?>" class="delete" onclick="return confirm('Czy na pewno chcesz usunąć tę notatkę?');">Usuń</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Brak notatek. Dodaj nową notatkę!</p>
      <?php endif; ?>
      <div class="add-note">
        <a href="add.php" class="add">&#10010;</a>
      </div>
    </section>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>