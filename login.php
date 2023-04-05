<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Login</title>
</head>

<body>
	<?php
		$log = '';
		$pas = '';
		if (isset($_POST["register"])) {
			header('Location: new_guest.php');
		}
		if (isset($_POST["log"]) and isset($_POST["pas"])) {
			$log = $_POST["log"];
			$pas = $_POST["pas"];
			$con=mysqli_connect("localhost","root","pass","proj");
			$result = mysqli_query($con, "SELECT * FROM `users` where `login`='" . $log."' AND `password`='" . $pas."'");
			if ($result->num_rows!==0) {
				session_start();
				$_SESSION['name']=$log;
				$_SESSION['level']=mysqli_fetch_array($result)[3];
				if ($_SESSION['level'] >= 90) {
					header('Location: admin.php');
				} else {
					header('Location: main.php');
				}
			} else {
				echo "Введены неверные данные";
			}
			mysqli_close($con);
		}	
	?>
	<form action="login.php" method="post">
		<label>Логин:</label>
		<input type="text" name="log" id="log"><br><br>
		<label>Пароль:</label>
		<input type="text" name="pas" id="pas"><br><br>
		<input type="submit" value="Вход">
	</form>
	<br>
	<form action="login.php" method="post">
		<input type="submit" class="button" name="register" id="register" value="Регистрация">
	</form>
</body>

</html>