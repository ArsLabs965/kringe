<?php
    session_start();
    include "../settings/db.php";
    $connection = connect();
    $logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$_SESSION[user]'");
    if(($ac = mysqli_fetch_assoc($logge))){
        $coins = $ac['coins'];
        $coins += $ac['level'];
        mysqli_query($connection, "UPDATE `accaunts` SET `coins` = '$coins' WHERE `login` = '$_SESSION[user]'");
        echo $coins;
    }
?>