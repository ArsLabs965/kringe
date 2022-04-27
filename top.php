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
    <title>Топ - Казино кринж</title>
</head>
<body>
    <div class="center">
        <a href="coin.php">Назад</a><br><br><br>
        <?php
            $logge = mysqli_query($connection, "SELECT * FROM `accaunts` ORDER BY `coins` DESC LIMIT 100");
            while(($ac = mysqli_fetch_assoc($logge))){
                echo $ac['login'] . " --- " . $ac['coins'] . " LCN";
            }
        ?>
    </div>
</body>
</html>