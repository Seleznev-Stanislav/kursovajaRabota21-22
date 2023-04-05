<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Create course entry</title>
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
	
	$courses = "SELECT * FROM `courses`";
	$orgs = "SELECT * FROM `orgs`";
	$types = "SELECT * FROM `types`";
	if ($stmt = $con->prepare($courses)) {
		$stmt->execute();
		$stmt->store_result();
		$newid = ($stmt->num_rows) + 1;
	}
	
	if (isset($_POST['name'])) {
		if (!($_POST['level'] < $_SESSION['level'])) {
			echo "<br>!!!Задан уровень выше или равный своему!!!";
		} else {
			$value = "'";
			$value .= $newid;
			$value .="', '";
			$value .= $_POST['orgid'];
			$value .="', '";
			$value .=$_POST['name'];
			$value .="', '";
			$value .=$_POST['typeid'];
			$value .="', '";
			$value .=$_POST['level'];
			$value .="', '";
			$value .=$_POST['content'];
			$value .="'";
			$query = "INSERT INTO `courses` (id, orgid, name, typeid, level, content) VALUES (" . $value. ")";
			if ($con->query($query) === TRUE) {
				echo "New record created successfully";
			}
		}
	}
	
	$query = "SELECT * FROM `orgs`";
	$orgsq = $con -> query($query);
	
	$query = "SELECT * FROM `types`";
	$typesq = $con->query($query);
	
	mysqli_close($con);
	?>
	
	<form action="new_post.php" method="post">
		<p>Введите данные нового курса:</p>
		<p><label> Институт	
			<select name="orgid">
			<?php
                while ($orgs_array = mysqli_fetch_array($orgsq,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $orgs_array["id"];?>">
                    <?php echo $orgs_array["name"];?>
                </option>
            <?php
                endwhile;
            ?>
			</select></label></p>
		<p><input name="name" id="name" required placeholder="name"></p>
		<p><label> Тип	
			<select name="typeid">
			<?php
                while ($types_array = mysqli_fetch_array($typesq,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $types_array["id"];?>">
                    <?php echo $types_array["name"];?>
                </option>
            <?php
                endwhile;
            ?>
			</select></label></p>
		<p><input name="level" id="level" required placeholder="level"></p>
		<p><textarea name="content" id="content" required placeholder="content"></textarea></p>
		<p><input type="submit" value="Создать"></p>
	</form>
	
	<br><br>
	
	<form action="new_post.php" method = "post">
		<input type="submit" class="button" name="admin" id="admin" value="Назад"><br><br>
	</form>
	</body>
</html>