<?php session_start(); $n=$_GET['cid']; ?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<?php echo "<title>Course " . $n."</title>"; ?>
	</head>
	
	<body>
	<?php
	if ($_SESSION['level'] == null) {
		header('Location: login.php');
	}
	
	$con=mysqli_connect("localhost","root","pass","proj") or die("Unable to connect to the database");
	
	$name = mysqli_query($con, "SELECT `name` FROM `courses` WHERE `id`='" . $n. "'");
	$content = mysqli_query($con, "SELECT `content` FROM `courses` WHERE `id`='" . $n. "'");
	
	$orgid = mysqli_query($con, "SELECT `orgid` FROM `courses` WHERE `id`='" . $n. "'");
	$orgname = mysqli_query($con, "SELECT `name` FROM `orgs` WHERE `id`='" . mysqli_fetch_array($orgid)[0]. "'");
	
	$typeid = mysqli_query($con, "SELECT `typeid` FROM `courses` WHERE `id`='" . $n. "'");
	$typename = mysqli_query($con, "SELECT `name` FROM `types` WHERE `id`='" . mysqli_fetch_array($typeid)[0]. "'");
	
	echo "Наименование курса: " . mysqli_fetch_array($name)[0]. "<br><br>";
	echo "Тип программы: " . mysqli_fetch_array($typename)[0]. "<br><br>";
	echo "Структуное подразделение: " . mysqli_fetch_array($orgname)[0]. "<br><br>";
	echo "Описание: " . mysqli_fetch_array($content)[0];
	
	mysqli_close($con);
	
	if (isset($_POST['main'])) {
		header('Location: main.php');
	}
	
	if ((isset($_POST['edit'])) and ($_SESSION['level'] >= 90)) {
		header('Location: edit_post.php?id=1');
	}
	?>
	<br><br>
	<form action="course.php" method = "post">
		<input type="submit" class="button" name="main" id="main" value="На главную"><br><br>
	</form>
	
	<br><br>
	
	<?php
	if ($_SESSION['level'] >= 90) {
		echo '<form action="course.php" method = "post">';
			echo '<input type="submit" class="button" name="edit" id="edit" value="Редактировать"><br><br>';
		echo '</form>';
	}
	?>
	
	</body>
	
</html>