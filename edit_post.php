<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Edit course entry</title>
	</head>
	
	<body>
	<?php
	
	$url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$url_components = parse_url($url);
	parse_str($url_components['query'], $params);
	$n=$params['id'];
	if ($_SESSION['level'] < 90) {
		header('Location: login.php');
	}
	if (isset($_POST['main'])) {
		header('Location: main.php');
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
	
	$current_name = mysqli_query($con, "SELECT `name` FROM `courses` WHERE `id`='" . $n. "'");
	$current_content = mysqli_query($con, "SELECT `content` FROM `courses` WHERE `id`='" . $n. "'");
	
	if (isset($_POST['name'])) {
		if (!($_POST['level'] < $_SESSION['level'])) {
			echo "<br>!!!Задан уровень выше или равный своему!!!";
		} else {
			$post_orgid = $_POST['orgid'];
			$post_name =$_POST['name'];
			$post_typeid =$_POST['typeid'];
			$post_level =$_POST['level'];
			$post_content =$_POST['content'];
			
			$query = "UPDATE `courses` SET `orgid` = ".$post_orgid.", `name`='".$post_name."', `typeid`=".$post_typeid.", `level`=".$post_level.", `content`='".$post_content."' WHERE `id`= 1";
			if ($con->query($query) === TRUE) {
				echo "Edit successful";
			}
		}
	}
	
	$query = "SELECT * FROM `orgs`";
	$orgsq = $con -> query($query);
	
	$query = "SELECT * FROM `types`";
	$typesq = $con->query($query);
	
	mysqli_close($con);
	?>
	
	<form action="edit_post.php" method="post">
		<p>Данные курса:</p>
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
		<p><input name="name" id="name" value="Основные направления консультативной работы с семьей"></p>
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
		<p><input name="level" id="level" value="15"></p>
		<p><textarea name="content" id="content">Актуальность данной программы связана с высоким процентов обращений населения по вопросам семейных отношений (80% из всех проблем).Необходима помощь молодым семьям в кризистых ситуациях. Востребованность данной программы связана с необходимостью в профилактических мерах по урегулированию разводных ситуаций, конфликтов в семьях, гармонизации детстко-родительских отношений в семьях разных возрастов. Программа носит проектно-ориентированный характер и направлена на формирование практических навыков. Сформированность заявленных навыков и компетенций оценивается в результате итоговой аттестации. Цель программы: 1. Развитие и совершенствование профессиональных компетенций, необходимых для выполнения нового вида профессиональной деятельности-семейного консультирования. 2. Получение новых компетенций для выполнения нового вида профессиональной деятельности ? семейного консультирования.На данной программе смогут обучаться слушатели из других городов. Телефон для записи: +7(ххх)ххх-хх-хх</textarea></p>
		<p><input type="submit" value="Сохранить"></p>
	</form>
	
	<br><br>
	
	<form action="edit_post.php" method = "post">
		<input type="submit" class="button" name="main" id="main" value="Отмена"><br><br>
	</form>
	</body>
</html>