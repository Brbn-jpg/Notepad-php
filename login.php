<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['login'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        $stmt = $con->prepare("SELECT * FROM users WHERE user_name = ? LIMIT 1");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: index.php");
                exit;
            } else {
                echo "Nieprawidłowe hasło!";
            }
        } else {
            echo "Nie znaleziono użytkownika!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php include 'modules/nav.php'; ?>
    <hr />
    <article>
      <h2>Logowanie</h2>
      <form action = "notes.php" method="POST">
        <label for="text">Login</label>
        <input
          type="text"
          name="login"
          class="username"
          required
          placeholder="np. Mariusz"
        />
        <label for="password">Hasło</label>
        <input
          type="password"
          name="password"
          class="password"
          required
          placeholder="Wprowadź hasło"
        />
        <button type="submit" class="submit-btn">Zaloguj</button>
      </form>
    </article>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>
