<?php

	require 'config.php';
	require 'class/DbHandler.class.php';
	
	if(isset($_GET['id'])) {
		$id = array(':id' => $_GET['id']);

		if(isset($_GET['delete'])) {
			$sql = 'DELETE FROM users WHERE id = :id';
			$result = DbHandler::execute($sql, $id);
			header('Location: index.php');
		}
		
		$sql = 'SELECT * FROM users WHERE id = :id';		
		$user = DbHandler::getRow($sql, $id);
	}

?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="main.css"/>
</head>
<body>	

	<div class="container">
		<h2>Личный кабинет пользователя</h2>
		<br />
		<h1><?= $user['u_name'] ?></h1>
		<br />
		<p>Возраст: <strong><?= $user['u_age'] ?></strong></p>
		<p>Телефон: <strong><?= $user['u_phone'] ?></strong></p>
		<p>Email: <strong><?= $user['u_email'] ?></strong></p>
		<p>Город: <strong><?= $user['u_city'] ?></strong></p>
		<p>Индекс: <strong><?= $user['u_mailindex'] ?></strong></p>
		<br /><br />
		<p>
			<a class="btn" href="index.php?id=<?= $user['id'] ?>&edit=1">Измениь данные</a>
			<a class="btn btn-danger" href="cabinet.php?id=<?= $user['id'] ?>&delete=1">Удалить профиль</a>
		</p>
		<?php if(isset($user['u_photo'])) { ?>
			<div id="userphoto">
				<img src="upload/<?= $user['u_photo']?>" alt="" />
			</div>
		<?php } ?>
	</div>

</body>
</html>		
		
		
		