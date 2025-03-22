<?php
session_start();
include("connection.php");
include("functions.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php include 'modules/nav-logged.php'; ?>
    <section class="add-note-section">
      <h2 class="user-notes">Dodaj nową notatkę</h2>
      <form method="POST" action="save_note.php">
        <label class="note-label" for="title">Tytuł notatki</label>
        <input
          type="text"
          name="title"
          class="note-title-input"
          required
          placeholder="Wprowadź tytuł notatki"
        />

        <label class="note-label" for="content">Treść notatki</label>
        <textarea
          name="content"
          class="note-content"
          required
          placeholder="Wprowadź treść notatki"
        ></textarea>

        <button type="submit" class="submit-btn">Dodaj notatkę</button>
      </form>
    </section>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>