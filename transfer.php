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
$err = 0;
if(isset($_POST['send'])){
    $login = mysqli_real_escape_string($connection, $_POST['login']);
    $colvo = mysqli_real_escape_string($connection, $_POST['colvo']);
    $colvo = preg_replace("/[^0-9]/", '', $colvo);
    if($login != '' && $colvo != ''){
    $recv = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$_SESSION[user]'");
            if(($ac = mysqli_fetch_assoc($recv))){
                $recve = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");
            if(($acc = mysqli_fetch_assoc($recve))){
                if($colvo > 0){
                    $coinsme = $ac['coins'];
                    $coinslogin = $acc['coins'];
                    if($coinsme >= $colvo){
                        if($login != $_SESSION['user']){
                        $coinsme -= $colvo;
                        $coinslogin += $colvo;
                        mysqli_query($connection, "UPDATE `accaunts` SET `coins` = '$coinsme' WHERE `login` = '$_SESSION[user]'");
                        mysqli_query($connection, "UPDATE `accaunts` SET `coins` = '$coinslogin' WHERE `login` = '$login'");
                        $err = 5;
                        }else{
                            $err = 6;
                        }
                    }else{
                        $err = 4;
                    }
                }else{
                    $err = 3;
                }
            }else{
                $err = 1;
            }
                
            }
        }else{
            $err = 2;
        }
            
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Перевод - Казино кринж</title>
</head>
<body>
    <div class="center">
        <h3><?php echo $_SESSION['user']; ?></h3><a href="coin.php">Выйти</a><br><br><br>
        <h1 id="coins"><?php
            $recv = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$_SESSION[user]'");
            if(($ac = mysqli_fetch_assoc($recv))){
                echo $ac['coins'];
            }
        ?><a class="grey"> LCN</a></h1><br><br>

       
        <div class="form">
            <h3>Перевод</h3>
            <p class="errors"><?php
                if($err == 2){
                    echo "Заполните поля!";
                }
                if($err == 1){
                    echo "Логин не найден!";
                }
                if($err == 3){
                    echo "Недопустимые значения";
                }
                if($err == 4){
                    echo "Не достаточно средств";
                }
                if($err == 5){
                    echo "ПЕРЕВОД ПРОШЁЛ УСПЕШНО!";
                }
                if($err == 6){
                    echo "Нельзя перевести самому себе";
                }
            ?></p>
           <form action="" method="post">
               Кому сделать перевод?<br>
               <input type="text" name="login" placeholder="Логин"><br><br>
               Сколько перевести?<br>
               <input type="number" name="colvo" placeholder="LCN"><br><br>
               <input type="submit" name="send" value="Отправить"><br><br>
           </form>

        </div>
    </div>
  
</body>
</html>