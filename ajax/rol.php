<?php
    session_start();
    include "../settings/db.php";
    $connection = connect();
    $chance = mysqli_real_escape_string($connection, $_GET['chance']);
    $stavka = mysqli_real_escape_string($connection, $_GET['stavka']);
   
    $logge = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$_SESSION[user]'");
    if(($ac = mysqli_fetch_assoc($logge))){
        if($chance != '' && $stavka != ''){
            if($chance < 2 || $chance > 94 || $stavka < 100 || $stavka > $ac['coins']){
               
            }else{
                $result = round(($stavka * (100 / $chance)) * 0.95);
                $coins = $ac['coins'];
        $gona = rand(0, 100);
        if($gona < $chance){
            $coins += $result;
        }
            $coins -= $stavka;
        
        
       
        mysqli_query($connection, "UPDATE `accaunts` SET `coins` = '$coins' WHERE `login` = '$_SESSION[user]'");
        echo $coins;
            }
        }
        
    }
?>