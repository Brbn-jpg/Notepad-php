<?php
session_start();

  include("connection.php");
  include("functions.php");

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    //stmh was posted
    $user_name = $_POST['login'];
    $password = $_POST['password'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name)){
      $query = "select * from users where user_name = '$user_name' limit 1";

      $result = mysqli_query($con, $query);
      if($result){
        if($result && mysqli_num_rows($result) > 0){
          $user_data = mysqli_fetch_assoc($result);
          if($user_data['password'] === $password){
            $_SESSION['user_id'] = $user_data['user_id'];
            header("Location: index.php");
            die;  
          }
        }
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
