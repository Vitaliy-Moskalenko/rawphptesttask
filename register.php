<?php

	require 'config.php';
	require 'class/DbHandler.class.php';
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {		
		$user = array(
			':name'      => $_POST['name'],
			':age'       => $_POST['age'],
			':phone'     => $_POST['phone'],
			':email'     => $_POST['email'],			
			':city'      => $_POST['city'],			
			':mailindex' => $_POST['mailindex'],			
			':password'  => md5($_POST['password']),
			':imgfile'   => 'no photo'	
		);	
		
		if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
			$maxsize = 25 * 1024 * 1024;
			$allowedFileTypes = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
			$filename  = $_FILES["photo"]["name"];
			$filetype  = $_FILES["photo"]["type"];
			$filesize  = $_FILES["photo"]["size"];			
			$extension = pathinfo($filename, PATHINFO_EXTENSION);

			if(!array_key_exists($extension, $allowedFileTypes) || $filesize > $maxsize)
				header('Location: index.php?err=Ошибка загрузки изображения');
			
            move_uploaded_file($_FILES["photo"]["tmp_name"], "upload/" . $filename);
			$user[':imgfile'] = $filename;
		}	
		
		if($_POST['edit_user'] != '') { // Update user
			$user['id'] = $_POST['edit_user'];
			$sql = "UPDATE users SET u_name=:name, u_age=:age, u_phone=:phone, u_email=:email, u_city=:city, u_mailindex=:mailindex, u_password=:password, u_photo=:imgfile WHERE id = :id";
			$result = DbHandler::execute($sql, $user);
			
			if($result == 'ok') 
				header('Location: cabinet.php?id='.$_POST['edit_user']);
			else 
				header('Location: index.php?err=Ошибка обновления данных');				
			
		}	
		else {			
			// Save user in database
			$sql = "INSERT INTO users (u_name, u_age, u_phone, u_email, u_city, u_mailindex, u_password, u_photo)
							   VALUES (:name, :age, :phone, :email, :city, :mailindex, :password, :imgfile);"; 
			
			$result = DbHandler::insert($sql, $user);  
			
			if(!preg_match('/^[0-9]+$/', $result)) { 
				header('Location: index.php?err='.$result);
			}
			else {
				$to = $_POST['email'];
				$subject = "Регистрация в личном кабинете";
				$message = "Вы успешно зарегистрировались!";
				$headers = "From: sender@example.com";

				mail($to, $subject, $message, $headers);			
			
				echo '<p style="color:green;">Пользователь зарегистрирован успешно.</p>';
				header('Location: index.php?success=ok&id='.$result);
			}
		}	
	}
	else
		header('Location: index.php');
