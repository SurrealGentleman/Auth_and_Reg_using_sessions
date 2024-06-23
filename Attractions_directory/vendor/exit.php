<?
   session_start();
   unset($_SESSION['id_user']);
   unset($_SESSION['message']);
   header('Location: ../pages/authorization.php');
?>