<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Main</title>
</head>

<body>
	<form action="main.php" method = "post">
		<input type="submit" class="button" name="quit" id="quit" value="Выход"><br><br>
	</form>
	<?php
	if ($_SESSION['level'] == null) {
		header('Location: login.php');
	} else if ($_SESSION['level'] >= 90) {
		echo '<form action="main.php" method = "post">';
		echo '<input type="submit" class="button" name="admin" id="admin" value="Admin"><br><br>';
		echo '</form>';
	}
	?>
	<form action="main.php" method="get">
		<label>Поиск по наименованию:</label>
		<input type="text" name="filter" id="filter">
		<input type="submit" value="Поиск"><br><br>
	</form>
	<?php
	if (isset($_POST['quit'])) {
		session_destroy();
		header('Location: login.php');
	}
	
	if (isset($_POST['admin'])) {
		header('Location: admin.php');
	}
	
	function drawPage($filter) {
		echo '<table border="1" width="95%" cellpadding="7">';
		echo '<tr>';
		echo '<th>Структурное подразделение</th>';
		echo '<th>Наименование программы</th>';
		echo '<th>Тип программы</th>';
		echo '</tr>';
	
		$con=mysqli_connect("localhost","root","pass","proj");
			
		$result = mysqli_query($con, "SELECT * FROM courses");
		if (!$result) {
			echo "Can't get to table";
		} else {
			$i=0;
			while($row = $result->fetch_assoc()){
				if ((str_contains($row["name"], $filter)) and ($_SESSION['level'] > $row['level'])) {
					$orgname = mysqli_query($con, "SELECT name FROM orgs WHERE id=" . $row["orgid"]);
					$typename = mysqli_query($con, "SELECT name FROM types WHERE id=" . $row["typeid"]);
					$href = "course.php?cid=" . ++$i;
					#$href = "courses/" . ++$i. ".php";
					echo "<tr><td>" . mysqli_fetch_array($orgname)[0] . "</td><td><a href=$href>" . $row["name"]. "</a></td><td>" . mysqli_fetch_array($typename)[0]. "</td></tr>";
				}
			}
		}
		mysqli_close($con);
		echo '</table>';
	}
	
	$filter = $_GET['filter'] ?? null;
	drawPage($filter);
	?>
</body>

</html>