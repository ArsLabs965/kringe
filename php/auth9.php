<?php


    //connection - sql connection
    //stoparray - stop symbols
    function reg9($connection, $stoparray){
       $login = sql9forauth($connection, $_POST[login]);
       $password = sql9forauth($connection, $_POST[password]);
        if($login != ''){
            if($password != ''){

                if(!($val = sym9forauth($login, $stoparray))){
                    $recv = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");
                    if(!($ac = mysqli_fetch_assoc($recv))){
                         $cryptpass = password_hash($password, PASSWORD_BCRYPT);
                        mysqli_query($connection, "INSERT INTO `accaunts` (`login`, `password`) VALUES ('$login', '$cryptpass')");

                        return "success";
                    }else{
                        return "login_has_been_created_before";
                    }
                }else{
                    return "stop_symbols_in_login";
                }
            }else{
                return "no_password";
            }
        }else{
            return "no_login";
        }
    }

    //connection - sql connection
    function sign9($connection){
        $login = sql9forauth($connection, $_POST[login]);
       $password = sql9forauth($connection, $_POST[password]);
       if($login != ''){
        if($password != ''){

           
                $recv = mysqli_query($connection, "SELECT * FROM `accaunts` WHERE `login` = '$login'");
                if(($ac = mysqli_fetch_assoc($recv))){
                    if(password_verify($password, $ac[password])){
                        return "success";
                    }else{
                        return "wrong_password";
                    }
                   

                   
                }else{
                    return "login_not_found";
                }
            
        }else{
            return "no_password";
        }
    }else{
        return "no_login";
    }
    }




    function sql9forauth($connection, $value){
        return mysqli_real_escape_string($connection, $value);
    }
    function sym9forauth($value, $array){
        $ready = str_replace($array, "", trim($value));
        if($ready == $value){
            return 0;
        }else{
            return $ready;
        }
        
    }
?>