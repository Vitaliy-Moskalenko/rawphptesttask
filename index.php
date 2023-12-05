<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="main.css"/>
</head>
<body>	

	<div class="container">
		<h1>Данные пользователя</h1>
		<?= isset($_GET['err']) ? '<div class="error">Ошибка: '.$_GET["err"].'</div>' : ''; ?>
		
		<?php if(isset($_GET['success']) && isset($_GET['id'])) { ?>
			<div class="success">
				<p>Регистрация прошла успешно</p>
				<a class="btn" href="cabinet.php?id=<?= $_GET['id'] ?>">Войти в личный кабинет</a>
			</div>		
		<?php } else { ?>	
			<form name="user-reg" action="register.php" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="edit_user" value="<?= (isset($_GET['edit'])) ? $_GET['id'] : '' ?>" />
				<label for="name"><span>*</span> Имя:</label>
				<input type="text" id="name" name="name" maxlength="50" required />
				
				<label for="name">Возраст:</label>
				<input type="number" id="age" name="age" min="10" max="100" />

				<label for="phone"><span>*</span> Телефон:</label>
				<input type="tel" id="phone" name="phone" pattern="[0-9()+ -]+" placeholder="+7 (___) ___-__ -__" required />
				
				<label for="email"><span>*</span> Email:</label>
				<input type="email" id="email" name="email" placeholder="mail@mail.ru" required />

				<label for="city">Город:</label>
				<input type="text" id="city" name="city" placeholder="Ваш город.." />
				
				<label for="mailindex">Почтовый индекс:</label>
				<input type="number" id="mailindex" name="mailindex" />
				<br /><br />		
				
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" placeholder="Ваш пароль.." required />
				
				<label for="photo">Фотография:</label>
				<input type="file" id="photo" name="photo" />				

				<input type="submit" value="Сохранить" />
			</form>	
		<?php } ?>
	</div>

</body>
</html>