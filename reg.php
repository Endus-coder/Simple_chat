<?php
session_start();

if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])){

	$login = htmlspecialchars(trim($_POST['login']));
	$password = htmlspecialchars(trim($_POST['password']));
	$email = htmlspecialchars(trim($_POST['email']));
	
	$hashPassword = password_hash($password,PASSWORD_DEFAULT);

	if($login =='' || $password == '' || $email == ''){
		die('Заполните все поля <br> <a href="index.php">Попробовать зарегистрироваться еще раз</a>');
	}

	require_once('bd.php');

	$stmt = $pdo->prepare("
		SELECT
			`login`
		FROM	
			`logins`
		WHERE
			`login` = :userLog	

		");

	$stmt->execute([
		':userLog' => $login

	]);
	$res = $stmt->fetchAll();

	if(!empty($res)){
		die('такой логин уже занят <br> <a href="index.php">Попробовать зарегистрироваться еще раз</a>');
	}

	if(strlen($password)<5){
		die('длинна пароля не может быть меньше 5 символов <br> <a href="index.php">Попробовать зарегистрироваться еще раз</a>');
	}

	$stmt = $pdo->prepare("
		INSERT INTO
			`logins` (
				`login`,
				`password`,
				`email`

			) VALUES (
				:login,
				:password,
				:email
			)


	");
	$stmt->execute([
		':login' => $login,
		':password' => $hashPassword,
		':email' => $email

	]);
	if($stmt == true){
		$_SESSION['login'] = $login;
		header("Location: /index.php");
	}else{
		echo 'Ошибка базы данных';
	}

}	

