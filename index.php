<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>
<!DOCTYPE html>
<html lang="pl">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php 
    if(isset($user_data)){
        include 'modules/nav-logged.php';
    }
    else {
        include 'modules/nav.php';
    }
    
    ?>
    <article>
    <h2>Witaj w notatniku</h2>

    <?php if (isset($_SESSION['user_id'])): ?>
      <p>👋 Witaj <?php echo htmlspecialchars($user_data['user_name']); ?>, jesteś zalogowany! Możesz korzystać z dodatkowych funkcji.</p>
    <?php else: ?>
      <p>🔑 Nie jesteś zalogowany. <a href="login.php">Zaloguj się</a>, aby uzyskać więcej możliwości.</p>
    <?php endif; ?>
      
      <p>
        Notatnik to aplikacja, która pozwala na zapisywanie notatek. Możesz
        zapisywać notatki, edytować je, usuwać i przeglądać. Wszystko to zrobisz
        w łatwy i przyjemny sposób.
      </p>
      <p>
        Aby korzystać z notatnika, musisz się zalogować. Jeśli nie masz konta,
        możesz je założyć. Wystarczy, że klikniesz w odpowiednią opcję w menu
        nawigacyjnym.
      </p>

    </article>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>