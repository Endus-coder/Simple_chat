<?php
session_start();
require_once('bd.php');
// простая система авторизации с проверкой хэша пароля, хранящегося в базе данных
 if(isset($_POST['username']) && isset($_POST['userpassword'])){
    $login=trim($_POST['username']);
    $password=trim($_POST['userpassword']);
        if(!empty($login) && !empty($password)){
            $sql = "SELECT login, password FROM logins WHERE login =:login";
            $params=[':login' => $login];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $user= $stmt->fetch(PDO::FETCH_OBJ);
                
                if($user){ 
                    if(password_verify($password, $user->password)){
                        $_SESSION['login'] = $login;
                        header('Location:/');
                        }else{
                           header('Location:/');
                                }header('Location:/');







        }header('Location:/');




    }
}

if(isset($_POST['restart'])){
    unset($_SESSION['login']);
}    
