<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Create user account</title>
	</head>
	
	<body>
	<?php
	if ($_SESSION['level'] < 90) {
		header('Location: login.php');
	}
	if (isset($_POST['admin'])) {
		header('Location: admin.php');
	}
	echo "Ваш уровень: " . $_SESSION['level']. "<br>";
	
	$con=mysqli_connect("localhost","root","pass","proj") or die("Unable to connect to the database");
	
	$users = "SELECT * FROM `users`";
	if ($stmt = $con->prepare($users)) {
		$stmt->execute();
		$stmt->store_result();
		$newid = ($stmt->num_rows) + 1;
	}
	
	if (isset($_POST['log'])) {
		if (!($_POST['level'] < $_SESSION['level'])) {
			echo "<br>!!!Задан уровень выше или равный своему!!!";
		} else {
			$value = "'";
			$value .= $newid;
			$value .="', '";
			$value .= $_POST['log'];
			$value .="', '";
			$value .=$_POST['pas'];
			$value .="', '";
			$value .=$_POST['level'];
			$value .="'";
			
			$query = "INSERT INTO `users` (id, login, password, level) VALUES (" . $value. ")";
			if ($con->query($query) === TRUE) {
				echo "New record created successfully";
			}
		}
	}
		
	mysqli_close($con);
	?>
	
	<form action="new_user.php" method="post">
		<p>Введите данные нового пользователя:</p>
		<p><input name="log" id="log" required placeholder="login"></p>
		<p><input name="pas" id="pas" required placeholder="password"></p>
		<p><input name="level" id="level" required placeholder="level"></p>
		<p><input type="submit" value="Создать"></p>
	</form>
	
	<br><br>
	
	<form action="new_user.php" method = "post">
		<input type="submit" class="button" name="admin" id="admin" value="Назад"><br><br>
	</form>
	</body>
	
</html>