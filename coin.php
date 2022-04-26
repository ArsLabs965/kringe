<?php
session_start();
include "settings/db.php";
include "settings/root_way.php";
include "php/auth9.php";
$connection = connect();
$rootway = root_way();

if($_SESSION['user'] == NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/" . $rootway . "index.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Казино кринж</title>
</head>
<body>
    <div class="center">
        <h3><?php echo $_SESSION['user']; ?></h3><a href="out.php">Выйти</a><br><br><br>
        <h1 id="coins"><?php
            $recv = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$_SESSION[user]'");
            if(($ac = mysqli_fetch_assoc($recv))){
                echo $ac['coins'];
            }
        ?><a class="grey"> LCN</a></h1><br><br>

        <img onclick="cl()" src="img/btn.png" width="200px" alt="">
    </div>
    <script src="js/jq.js"></script>
    <script>
        function cl(){
            $.ajax({
      method: "GET",
      url: "ajax/click.php",
      dataType: "text",
      data: {},
      success: function(data){  
        $('#coins').html(data);
       
	}
});
        }
    </script>
</body>
</html>