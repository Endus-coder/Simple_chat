<?php

require_once('bd.php');
	ini_set('session.gc_maxlifetime', 25920000);
	ini_set('session.cookie_lifetime', 25920000);
	session_start();


?>
<style type="text/css">
	#messages{
			width: 850px;
			height: 590px;
			overflow: auto;
			border: 1px solid orange;
			border-radius: 10px;
			padding: 5px;
			letter-spacing: 1px;
			font-family: Geneva, Arial, Helvetica, sans-serif;
			}
	#postInfo{
		border-radius: 10px;
		font-size:30px;
	}
	#exit{
		border-radius: 10px;
		font-size:30px;
	}
	#text{
			width: 550px;
			height: 100px;
			border-radius: 7px;
	}
	body{
		background: url(/background1.png);
	}	

</style>
<?php
	if(isset($_SESSION['login'])){
	?>	

<body>
<center>
<table>
	<tr>
		<td>
			<div ><p id="messages"></p></div>
		</td>	
	</tr>
	
	<tr>
		<td>
		
			Сообщение <textarea rows="3" cols="45" name="text" id = "text"></textarea>
			
			<button id="postInfo">Отправить сообщение</button>
			<br> <button id = "exit">Выйти</button>
			
		</td>
	</tr>					
</table>
</center>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script>
	$(function(){
		
		
					function loadMessage(){
						$.ajax({
								type: 'POST',
							    url: '/obr_message.php',
							    data: { getAllMessage : '1' },
							    dataType: "json"
							    }).done(function(response) {	
									if(Array.isArray(response)){	
									$('#messages').empty();
									for(var i = 0; i<response.length; i++ ){
										$response = response[i].data + ' ' + response[i].name + ': ' + response[i].message + '<br>';
										$('#messages').append($response);
										$("#messages").scrollTop(90000);

										}
									 
									}else{
										console.log('пусто в чате');
									}

							    	});
									
								}
							
							




		$('#postInfo').click(function(){
			
			var $name = $('#getLogin').val();
			var $message = $('#text').val();
			var dt = new Date();
			// Кейсы для передачи месяца словом
			var mount = dt.getMonth();
					switch(mount){
						case 0:
						mount = 'января';
						break;
						case 1:
						mount = 'февраля';
						break;
						case 2:
						mount = 'марта';
						break;
						case 3:
						mount = 'апреля';
						break;
						case 4:
						mount = 'мая';
						break;
						case 5:
						mount = 'июня';
						break;
						case 6:
						mount = 'июля';
						break;
						case 7:
						mount = 'августа';
						break;
						case 8:
						mount = 'сентября';
						break;
						case 9:
						mount = 'октября';
						break;
						case 10:
						mount = 'ноября';
						break;
						case 11:
						mount = 'декабря';
						break;
					}	

			$data = dt.getDay() + ' ' + mount + ' ' + dt.getFullYear() + ' года' + ' в ' + dt.getHours() + " часов - " + ' ' + dt.getMinutes() + " минут";
			$.ajax({
								type: 'POST',
							    url: '/obr_message.php',
							    data: { add : '1',nickname : $name, message : $message, data : $data },
							    dataType: "json"
							    }).done(function(response) {	
									console.log(response);
									$('#text').val('');
									$('#getLogin').val('');
									 


							    });
					

		



		});


		loadMessage();
		setInterval(loadMessage,2000);
			$('#exit').click(function(){
				$.post('/login.php', {restart: '1'});
				location.reload();



			});
		
	
			$("#text").keyup(function(event){
				    if(event.keyCode == 13){
				        $("#postInfo").click();
				        $(this).val('');
				    }
});




	});
</script>
	</center>

	<?php
		}else{
			// ниже обычная форма авторизации
			?>
			<center>
		<form action = "/reg.php" method="POST" id = "registarion">
		<h3> Регистрация в чате</h3>
		Логин: <br> <input type="text" name="login">
		<br>		
		Пароль: <br> <input type="password" name="password">
		<br>
		Электронная почта: <br> <input type="text" name="email">
		<br>
		<input type="submit" value="Зарегистрироваться">
		</form>

		<form action="login.php" method="POST" id = "avtorization">
			<h3>Вход на сайт</h3>
			Логин: <br> <input type="text" name="username">
			<br>
			Пароль: <br> <input type="password" name="userpassword">
			<br>
			<input type="submit" name="submit" value="Войти">

		</form>


	</center>
</body>


	<?php

		}
	?>











