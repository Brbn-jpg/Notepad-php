<?php
session_start();
include("connection.php");

<<<<<<< HEAD
$error_message = "";

=======
>>>>>>> 1ae6c9f8c77ed07e95568a1526d13a2d07de2283
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['login'];
    $password = $_POST['password'];

<<<<<<< HEAD
    if (empty($user_name) || empty($password)) {
        $error_message = "Proszę wypełnić wszystkie pola.";
    } else {
=======
    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
>>>>>>> 1ae6c9f8c77ed07e95568a1526d13a2d07de2283
        $stmt = $con->prepare("SELECT * FROM users WHERE user_name = ? LIMIT 1");
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

<<<<<<< HEAD
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
=======
        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

>>>>>>> 1ae6c9f8c77ed07e95568a1526d13a2d07de2283
            if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: index.php");
                exit;
            } else {
<<<<<<< HEAD
                $error_message = "Błędne hasło.";
            }
        } else {
            $error_message = "Nie znaleziono użytkownika o podanym loginie.";
=======
                echo "Nieprawidłowe hasło!";
            }
        } else {
            echo "Nie znaleziono użytkownika!";
>>>>>>> 1ae6c9f8c77ed07e95568a1526d13a2d07de2283
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
      <form method="POST">
        <label for="text">Login</label>
        <input
          type="text"
          name="login"
          class="username"
          required
          placeholder="np. Mariusz"
          value="<?php echo isset($user_name) ? $user_name : ''; ?>" 
        />
        <?php if ($error_message && strpos($error_message, "login") !== false): ?>
          <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <label for="password">Hasło</label>
        <input
          type="password"
          name="password"
          class="password"
          required
          placeholder="Wprowadź hasło"
        />
        <?php if ($error_message && strpos($error_message, "hasło") !== false): ?>
          <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if ($error_message && strpos($error_message, "wszystkie pola") !== false): ?>
          <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <button type="submit" class="submit-btn">Zaloguj</button>
      </form>
    </article>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>
