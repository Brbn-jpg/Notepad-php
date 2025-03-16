<!DOCTYPE html>
<html lang="en">
  <?php include 'modules/header.php'; ?>
  <body>
    <?php include 'modules/nav.php'; ?>
    <hr />
    <article>
      <h2>Logowanie</h2>
      <form action="register.php" method="POST">
        <label for="email">Email</label>
        <input
          type="text"
          name="email"
          class="username"
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
        <button type="submit" class="submit-btn">Zarejestruj</button>
      </form>
    </article>
    <?php include 'modules/footer.php'; ?>
  </body>
</html>
