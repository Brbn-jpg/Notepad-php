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

$query = "SELECT * FROM history WHERE user_id = ? ORDER BY changed_at DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php include 'modules/nav-logged.php'; ?>
    <section class="notes-section">
      <h2 class='user-notes'>Historia usuniętych notatek</h2>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($note = $result->fetch_assoc()): ?>
            <div class="note">
                <a href="view_deleted_note.php?id=<?php echo $note['id']; ?>" class="note-link">
                    <h2 class="note-title"><?php echo htmlspecialchars($note['title']); ?></h2>
                </a>
                <div class="note-meta">
                    <p><strong>Usunięto:</strong> <?php echo $note['changed_at']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Brak usuniętych notatek.</p>
      <?php endif; ?>
    </section>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>