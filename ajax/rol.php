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
                $logget = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = 'BOSS'");
    if(($acc = mysqli_fetch_assoc($logget))){
                $coinsboss = $acc['coins'];
    }
        $gona = rand(0, 100);
        $lost = $ac['lost'];
        if($gona < $chance){
            $coins += $result;
            $coinsboss -= $result;
        }else{
            $lost += $stavka;
            
        }
            $coins -= $stavka;
            $coinsboss += $stavka;
            
        
        mysqli_query($connection, "UPDATE `accaunts` SET `coins` = '$coinsboss' WHERE `login` = 'BOSS'");
        mysqli_query($connection, "UPDATE `accaunts` SET `coins` = '$coins' WHERE `login` = '$_SESSION[user]'");
        mysqli_query($connection, "UPDATE `accaunts` SET `lost` = '$lost' WHERE `login` = '$_SESSION[user]'");
        echo $coins;
            }
        }
        
    }
?>