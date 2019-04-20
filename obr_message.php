<?php
session_start();
include("bd.php");
if(isset($_POST['add']) && $_POST['message'] !=='' && $_POST['message'] !== ' '){
	$stmt = $pdo->prepare("
		INSERT INTO
			`user_message`(
				`name`,
				`message`,
				`data`
			) VALUES (
				:name,
				:message,
				:data
			)
			
		");




	$stmt->execute([
		':name' => $_SESSION['login'],
		':message' => $_POST['message'],
		':data' => $_POST['data']
	]);
	echo json_encode($response = 'сообщение добавлено в базу данных');
}

	if(isset($_POST['getAllMessage'])){
		$stmt = $pdo->prepare("
			SELECT
				`*`
			FROM
				`user_message`	

			");
		$stmt->execute();
		$response = $stmt->fetchAll();
	echo json_encode($response);
	}









	// $stmt->execute();

	// $stmt = $pdo->prepare("
	// 	SELECT
	// 		`*`
	// 	FROM	
	// 		`user_message`



	// 	");
// }
























			

				

	



