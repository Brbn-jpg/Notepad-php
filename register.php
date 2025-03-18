<?php
session_start();
include("connection.php");
<<<<<<< HEAD

$login_error = $password_error = $password_mismatch_error = $registration_success = $general_error = false;

=======
include("functions.php");

>>>>>>> 1ae6c9f8c77ed07e95568a1526d13a2d07de2283
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['login'];
    $password = $_POST['password'];
    $repeatedPassword = $_POST['repeatedPassword'] ?? null;

<<<<<<< HEAD
    if (empty($user_name) || empty($password) || empty($repeatedPassword)) {
        $general_error = true;
    }

    if ($password !== $repeatedPassword) {
        $password_mismatch_error = true;
    }

    if (!$general_error && !$password_mismatch_error) {
        $stmt = $con->prepare("SELECT * FROM users WHERE user_name = ?");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            $login_error = true;
        } else {
            $user_id = uniqid('', true); 
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

            $stmt = $con->prepare("INSERT INTO users (user_id, user_name, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $user_id, $user_name, $hashed_password);

            if ($stmt->execute()) {
                $registration_success = true;
            } else {
                $general_error = true;
            }
        }
    }
=======
    if (!empty($user_name) && !empty($password) && !empty($repeatedPassword) && !is_numeric($user_name)) {
        if ($password !== $repeatedPassword) {
            echo "Hasła nie są takie same!";
            exit;
        }

        $user_id = random_num(20);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $con->prepare("INSERT INTO users (user_id, user_name, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_id, $user_name, $hashed_password);
        if ($stmt->execute()) {
            echo "Rejestracja zakończona sukcesem!";
        } else {
            echo "Błąd podczas rejestracji!";
        }
    }
>>>>>>> 1ae6c9f8c77ed07e95568a1526d13a2d07de2283
}
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php include 'modules/nav.php'; ?>
    <hr />
    <article>
      <h2>Rejestracja</h2>
<<<<<<< HEAD
      <form method="POST">
=======
      <form action = "login.php" method="POST">
>>>>>>> 1ae6c9f8c77ed07e95568a1526d13a2d07de2283
        <label for="login">Login</label>
        <input
          type="text"
          name="login"
          class="username"
          required
          placeholder="np. Mariusz12"
        />
        <?php if ($login_error): ?>
          <p class="error">Użytkownik o takim loginie już istnieje.</p>
        <?php endif; ?>

        <label for="password">Hasło</label>
        <input
        type="password"
        name="password"
        class="password"
        required
        placeholder="Wprowadź hasło"
        />
        
        <label for="repeatedPassword">Powtórz hasło</label>
        <input
        type="password"
        name="repeatedPassword"
        class="password"
        required
        placeholder="Powtórz hasło"
        />
        <?php if ($password_mismatch_error): ?>
          <p class="error">Hasła się nie zgadzają! Proszę spróbować ponownie.</p>
        <?php endif; ?>

        <?php if ($general_error): ?>
          <p class="error">Proszę wypełnić wszystkie pola.</p>
        <?php endif; ?>

        <?php if ($registration_success): ?>
          <p class="success">Rejestracja zakończona sukcesem!</p>
        <?php endif; ?>

        <button type="submit" class="submit-btn">Zarejestruj</button>
      </form>
    </article>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>
