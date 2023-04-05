<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Create guest account</title>
	</head>
	
	<body>
	<?php
	if (isset($_POST['login'])) {
		header('Location: login.php');
	}
	
	$con=mysqli_connect("localhost","root","pass","proj") or die("Unable to connect to the database");
	
	$users = "SELECT * FROM `users`";
	if ($stmt = $con->prepare($users)) {
		$stmt->execute();
		$stmt->store_result();
		$newid = ($stmt->num_rows) + 1;
	}
	
	if (isset($_POST['log'])) {
		
			$value = "'";
			$value .= $newid;
			$value .="', '";
			$value .= $_POST['log'];
			$value .="', '";
			$value .=$_POST['pas'];
			$value .="', '";
			$value .=1;
			$value .="'";
			
			$query = "INSERT INTO `users` (id, login, password, level) VALUES (" . $value. ")";
			if ($con->query($query) === TRUE) {
				echo "New record created successfully";
			}
		
	}
		
	mysqli_close($con);
	?>
	
	<form action="new_guest.php" method="post">
		<p>Введите ваши данные:</p>
		<p><input name="log" id="log" required placeholder="login"></p>
		<p><input name="pas" id="pas" required placeholder="password"></p>
		<p><input type="submit" value="Создать"></p>
	</form>
	
	<br><br>
	
	<form action="new_guest.php" method = "post">
		<input type="submit" class="button" name="login" id="login" value="Назад"><br><br>
	</form>
	</body>
	
</html>