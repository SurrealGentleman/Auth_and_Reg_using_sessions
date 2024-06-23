<?
   session_start();
   if (!$_SESSION['id_user']) {
      header('Location: authorization.php');
   }
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
      <form class="exit" action="../vendor/exit.php" method="POST">
         <input type="submit" name="exit" value="Выйти">
      </form>
   </header>
   <main>
      <?php
         if (isset($_SESSION['message'])) {
            echo '<p class="msg">'.$_SESSION['message'].'</p>';
         }
      ?>
      <form method="POST">
         <label>Выберите достопримечательность</label>
            <?
               $masIDuser = array();
               require_once("../vendor/connectDB.php");
               $result = mysqli_query($connect, "SELECT * FROM attractions");
               foreach($result as $row){
                  $str = $row["id"]." - ".$row["attraction"];
                  array_push($masIDuser, $str);
               }
               mysqli_free_result($result);
               echo "<select name=masIDuser>";
               echo "<option></option>";
               foreach($masIDuser as $val){
                  echo "<option>$val</option>";
               }
               echo "</select>";
            ?>
         <input type="submit" name="search" value="Найти">
      </form>
      <div>
         <?php
            if(isset($_POST['search'])){
               if ($_POST['masIDuser']!="") {
                  $id = $_POST['masIDuser'];
                  $id = explode(" - ", $id);
                  $idstr = $id[0];
                  [$a, $b, $c] = att($idstr);
                  echo "<h1>".$a."</h1>";
                  echo $b;
                  echo "<div class=image><img src=../images/".$c."></div>";
               }
            }


            function att($idstr)
            {
               global $connect;
               $result = mysqli_query($connect, "SELECT * FROM attractions WHERE id = $idstr");
               foreach($result as $row){
                  if ($row['id'] < 10) {
                     $img = "t0".$row['id'].".jpg";
                  }
                  else{
                     $img = "t".$row['id'].".jpg";
                  }
                  return [$row['attraction'], $row['description'], $img];
               }
            }
         ?>
      </div>
   </main>
</body>
</html>