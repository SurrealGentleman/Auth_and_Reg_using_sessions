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
         <input type="submit" name="button" value="Войти">
         <p>Нет аккаунта, <a href="registration.php">зарегистрируйтесь!</a></p>
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
      $_SESSION['message'] = aut($_POST['login'], md5($_POST['password']));
      if ($_SESSION['message'] == "Подключение успешно") {
         header('Location: profile.php');
      }
      else if($_SESSION['message'] == "Ошибка: Не верный логин или пароль"){
         header('Location: authorization.php');
      }
   }

   function aut($login, $password)
   {
      require_once("../vendor/connectDB.php");
      $check_user = mysqli_query($connect, "SELECT * FROM profile WHERE login = '$login' AND password = '$password'");
      if (mysqli_num_rows($check_user) > 0) {
         $user = mysqli_fetch_assoc($check_user);
         $_SESSION['id_user'] = $user['id'];
         return "Подключение успешно";
      } else {
         return "Ошибка: Неверный логин или пароль";
      }
   }
?>