<?
   session_start();
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Справочник Достопримечательностей города</title>
   <link rel="stylesheet" href="../css/style.css">
</head>
<body>
   <header>
      <form action="" method="POST">
         <label>Логин</label>
         <input type="text" name="login" required>
         <label>Пароль</label>
         <input type="password" name="password" required>
         <label>Подтверждение пароля</label>
         <input type="password" name="password_confirm" required>
         <input type="submit" name="button" value="Зарегистрироваться">
         <p>Есть аккаунт, <a href="authorization.php">авторизируйтесь!</a></p>
      </form>
   </header>
   <main>
      <?
         if (isset($_SESSION['message'])) {
            echo '<p class="msg">'.$_SESSION['message'].'</p>';
         }
         unset($_SESSION['message']);
      ?>   
   </main>
</body>
</html>

<?
   if (isset($_POST['button'])) {
      $_SESSION['message'] = reg($_POST['login'], md5($_POST['password']), md5($_POST['password_confirm']));
      if ($_SESSION['message'] == "Профиль с таким логином уже существует") {
         header('Location: registration.php');
      }
      elseif ($_SESSION['message'] == "Пароли не совпадают") {
         header('Location: registration.php');
      }
      elseif ($_SESSION['message'] == "Регистрация прошла успешно") {
         header('Location: authorization.php');
      }
   }

   function reg($login, $password, $password_confirm)
   {
      require_once("../vendor/connectDB.php");
      $result = mysqli_query($connect, "SELECT * FROM profile");
      while ($row = mysqli_fetch_row($result)){
         if ($row[1] == $login) {
            return "Профиль с таким логином уже существует";
         }
      }
      if ($password == $password_confirm) {
         mysqli_query($connect, "INSERT INTO profile (login, password) VALUES ('$login', '$password')");
         return "Регистрация прошла успешно";
      }
      else{
         return "Пароли не совпадают";
      }
   }
?>