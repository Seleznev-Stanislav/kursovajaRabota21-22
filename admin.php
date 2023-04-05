<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Admin</title>
</head>

<body>
	<?php
	if ($_SESSION['level'] == null) {
		header('Location: login.php');
	}
	?>
	<form action="admin.php" method = "post">
		<input type="submit" class="button" name="main" id="main" value="На главную"><br><br>
	</form>
	
	<br>
	<form action="admin.php" method = "post">
		<input type="submit" class="button" name="cuser" id="cuser" value="Создать аккаунт"><br><br>
	</form>
	
	<form action="admin.php" method = "post">
		<input type="submit" class="button" name="cpost" id="cpost" value="Создать курс"><br><br>
	</form>
	
	<br><br>
	<form action="admin.php" method = "post">
		<input type="submit" class="button" name="quit" id="quit" value="Выход"><br><br>
	</form>
	<?php
	if (isset($_POST['quit'])) {
		session_destroy();
		header('Location: login.php');
	}
	
	if (isset($_POST['main'])) {
		header('Location: main.php');
	}
	
	if (isset($_POST['cuser'])) {
		header('Location: new_user.php');
	}
	
	if (isset($_POST['cpost'])) {
		header('Location: new_post.php');
	}
	?>
</body>

</html>