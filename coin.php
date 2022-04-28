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
if(isset($_POST['lvlup'])){
    $logget = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = 'BOSS'");
    if(($acc = mysqli_fetch_assoc($logget))){
                $coinsboss = $acc['coins'];
    }
    $recv = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$_SESSION[user]'");
    if(($ac = mysqli_fetch_assoc($recv))){
        if($ac['coins'] >= $ac['level'] * $ac['level'] * 1000){
            $level_l = $ac['level'] + 1;
            $coins_l = $ac['coins'] - $ac['level'] * $ac['level'] * 1000;
            $forboss = $coinsboss + $ac['level'] * $ac['level'] * 1000;
            $slil = $ac['lost'] + $ac['level'] * $ac['level'] * 1000;
            mysqli_query($connection, "UPDATE `accaunts` SET `coins` = '$forboss' WHERE `login` = 'BOSS'");
            mysqli_query($connection, "UPDATE `accaunts` SET `lost` = '$slil' WHERE `login` = '$_SESSION[user]'");
            mysqli_query($connection, "UPDATE `accaunts` SET `level` = '$level_l' WHERE `login` = '$_SESSION[user]'");
            mysqli_query($connection, "UPDATE `accaunts` SET `coins` = '$coins_l' WHERE `login` = '$_SESSION[user]'");
        }
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
        <h3><?php echo $_SESSION['user']; ?></h3><a href="out.php">Выйти</a><br><br><a href="top.php">Топ</a><br><br><br>
        <h1 id="coins"><?php
            $recv = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$_SESSION[user]'");
            if(($ac = mysqli_fetch_assoc($recv))){
                echo $ac['coins'];
            }
        ?><a class="grey"> LCN</a></h1><br><br>

        <img onclick="cl()" src="img/btn.png" width="200px" alt=""><br><br>
            Ваш уровень - <?php echo $ac['level']; ?><br><br>
                <div id="lvl">
                    
                </div>
        <br><br>
        <div class="form">
            <h3>Рулетка</h3>
            <a class="grey">Будет отниматься 5% от каждой выигранной суммы</a><br>
            Рулетка случайно выберет число от 0 до 100. Ставить можно от 100 LCN<br><br>
            Вы победите если выпадет от 0 до <input id="chance" value="50" style="width: 30px;" type="number"><br><br>
            Вы проиграете если выпадет от <a id="lose"></a> до 100<br><br>
            Ваша ставка - <input id="stavka" style="width: 80px;" type="number"><br><br>
            Если выиграете, получите <a id="get"></a><br><br>
            <div id="play_btn"></div>

        </div>
    </div>
    <script src="js/jq.js"></script>
    <script>
        var coins = <?php echo $ac['coins']; ?>;
        var level = <?php echo $ac['level']; ?>;
        function cl(){
            $.ajax({
      method: "GET",
      url: "ajax/click.php",
      dataType: "text",
      data: {},
      success: function(data){  
        $('#coins').html(data + '<a class="grey"> LCN</a>');
       coins = data;
       console.log(coins + " " + $("#stavka").val());
	}
});
        }

        function loop(){
            if(coins >= level * level * 1000){
                $("#lvl").html('<form action="" method="POST"><input class="green" type="submit" value="Повысить уровень" name="lvlup"></form>');
            }else{
                $("#lvl").html("Вам нужно " + level * level * 1000 + " LCN чтобы повысить уровень");
            }
            if($("#chance").val() != '' && $("#stavka").val() != ''){
                if($("#chance").val() < 2 || $("#chance").val() > 94 || $("#stavka").val() < 100 || $("#stavka").val() > coins){
                    $("#play_btn").html("Недопустимые значения!");
                }else{
                    $("#play_btn").html('<a class="green" onclick="pl()">Играть</a>');
                    $("#lose").html(1 + Number($("#chance").val()));
                    $("#get").html(Math.round(($("#stavka").val() * (100 / $("#chance").val())) * 0.95));
                }
            }else{
                $("#play_btn").html("Заполните поля!");
                $("#lose").html("[Заполните поля!]");
                $("#get").html("[Заполните поля!]");
            }
            
            setTimeout(loop, 10);
        }
        loop();

        function pl(){
            $.ajax({
      method: "GET",
      url: "ajax/rol.php",
      dataType: "text",
      data: {chance: $("#chance").val(), stavka: $("#stavka").val()},
      success: function(data){ 
          if(data == ''){
            alert("Ошибка");
          }else{    
        if(data > coins){
            alert("ВЫ ПОБЕДИЛИ!");
        }else{
            alert("Вы проиграли");
        }
        coins = data;
        $('#coins').html(data + '<a class="grey"> LCN</a>');
    }
	}
});
        }
    </script>
</body>
</html>