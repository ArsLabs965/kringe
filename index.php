<?php
session_start();
include "settings/db.php";
include "settings/root_way.php";
include "php/auth9.php";
$connection = connect();
$rootway = root_way();

if($_SESSION['user'] != NULL){
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/" . $rootway . "coin.php");
    exit();
}

$back_massage = '';
if(isset($_POST['reg'])){
    $back_massage = reg9($connection, [' ', '"', "'", '^', ';', ':', "/", "\\", '`']);
    if($back_massage == 'success'){
        $_SESSION['user'] = sql9forauth($connection, $_POST['login']);
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/" . $rootway . "coin.php");
        exit();
    }
}
if(isset($_POST['in'])){
    $back_massage = sign9($connection);
    if($back_massage == 'success'){
        $_SESSION['user'] = sql9forauth($connection, $_POST['login']);
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/" . $rootway . "coin.php");
        exit();
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
    <title>Казино кринж</title>
</head>
<body>
    <div class="center">
        <h1>Казино кринж</h1>beta
        <p class="errors"><?php
            if($back_massage == 'login_has_been_created_before'){
              echo 'Логин занят! Попробуйте другой';
            }
            if($back_massage == 'stop_symbols_in_login'){
                echo 'Вы используете запрещённые символы';
            }
            if($back_massage == 'no_password'){
                echo 'Пароль указывать тоже обязательно!';
            }
            if($back_massage == 'no_login'){
                echo 'Логин указывать тоже обязательно!';
            }
            if($back_massage == 'wrong_password'){
                echo 'Пароль неверен';
            }
            if($back_massage == 'login_not_found'){
                echo 'Логин не используется!';
            }
        ?></p>
        <div class="form">
            Вход
            <form action="" method="post">
                <input type="text" name="login" placeholder="Логин" value="<?php echo $_POST['login']; ?>"><br><br>
                <input type="password" name="password" placeholder="Пароль"><br><br>
                <input type="submit" name="in" value="Войти">
            </form>
        </div>
        <div class="form">
            Регистрация
            <form action="" method="post">
            <input type="text" name="login" placeholder="Логин" value="<?php echo $_POST['login']; ?>"><br><br>
                <input type="password" name="password" placeholder="Пароль"><br><br>
                <input type="submit" name="reg" value="Регистрация">
            </form>
        </div>
    </div>
    
</body>
</html>