<!DOCTYPE html>
<html lang="en">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php include 'modules/nav.php'; ?>
    <hr />
    <article>
      <h2>Rejestracja</h2>
      <form action="register.php" method="POST">
        <label for="login">Login</label>
        <input
          type="text"
          name="login"
          class="username"
          required
          placeholder="np. Mariusz12"
        />
        <label for="email">Email</label>
        <input
          type="text"
          name="email"
          class="email"
          required
          placeholder="np. Mariusz12@gmail.com"
        />
        
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

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $password = $_POST["password"];
                $repeatedPassword = $_POST["repeatedPassword"];
            
                if ($password !== $repeatedPassword) {
                    echo '<p class="error">Hasła nie są takie same</p>';
                }
            }
        ?>
        
        <button type="submit" class="submit-btn">Zarejestruj</button>
      </form>
    </article>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>
