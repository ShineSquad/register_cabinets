<?php
require "sql_functions.php";
require "db_link.php";

if (isset($_GET["add_discipline"])) {
	$name = $_GET["name"];
	insert_into($link, 
				"discipline", 
				'{
					"id": "NULL",
					"name": "'.$name.'"
				}');

	header("Location: add_data.php");
}

if (isset($_POST["add_software"])) {
	$updir = __DIR__ . "/license_docs/";

	$name = $_POST["name"];
	$ver  = $_POST["ver"];
	$type = $_POST["type"];

	$request = '{
		"id":         "NULL",
		"name":       "'.$name.'",
		"version":    "'.$ver.'",
		"type":       "'.$type.'"
	';

	if ($type == "pay") {
		$l_name   = $_POST["l_name"];
		$start_at = $_POST["start_at"];
		$end_at   = $_POST["end_at"];
		$doc_num  = $_POST["doc_num"];
		$doc_file = $updir . basename($_FILES['doc_link']['name']);
		move_uploaded_file($_FILES['doc_link']['tmp_name'], $doc_file);

		if ($_POST["unlim"]) $end_at = "NULL";

		insert_into($link, 
					'licenses',
					'{
						"id":       "NULL",
						"name":     "'.$l_name .'",
						"doc_num":  "'.$doc_num.'",
						"doc_file": "'.$doc_file.'",
						"start_at": "'.$start_at.'",
						"end_at":   "'.$end_at.'"
					}');
		$request .= ',
			"license_id": "'.mysqli_insert_id($link).'"
		';
	}

	$request .= '}';

	insert_into($link, "software", $request);

	header("Location: add_data.php");
}

if (isset($_GET["add_workplace"])) {
	insert_into($link, 
				"workplaces",
				'{
					"id": "NULL",
					"name": "'.$_GET["name"].'"
				}');
	$wp_ID = mysqli_insert_id($link);

	foreach ($_GET as $key => $value) {
		if ($key == "add_workplace" || $key == "name") continue;
		insert_into($link,
					"workplace_software",
					'{
						"id":           "NULL",
						"workplace_id": "'.$wp_ID.'",
						"software_id":  "'.$value.'"
					}');
	}

	header("Location: add_data.php");
}

if (isset($_GET["add_corpus"])) {
	insert_into($link, 
				"corpus",
				'{
					"id": "NULL",
					"name":   "'.$_GET["name"].'",
					"liter":  "'.$_GET["liter"].'",
					"adress": "'.$_GET["adress"].'"
				}');

	header("Location: add_data.php");
}

if (isset($_GET["add_cabinet"])) {
	$request = '{
		"id": "NULL",
		"name": "'      .$_GET["name"]     .'",
		"number": "'    .$_GET["number"]   .'",
		"corpus_id": "' .$_GET["corpus_id"].'",
		"type": "'      .$_GET["type"]     .'",
		"sit_place": "' .$_GET["sit_count"].'",
		"workplaces": "'.$_GET["workplaces"].'",
	';

	$lector_wp   = 0;
	$whiteboard  = 0;
	$proector    = 0;
	$interactive = 0;
	
	if (isset($_GET["lector_wp"]))   $lector_wp   = 1;
	if (isset($_GET["whiteboard"]))  $whiteboard  = 1;
	if (isset($_GET["proector"]))    $proector    = 1;
	if (isset($_GET["interactive"])) $interactive = 1;
	
	$request .= '
		"lector_wp": "'  .$lector_wp.'",
		"whiteboard": "' .$whiteboard.'",
		"proector": "'   .$proector.'",
		"interactive": "'.$interactive.'"
	}';

	insert_into($link, "cabinets", $request);

	header("Location: add_data.php");
}

if (isset($_GET["add_wp_at_cab"])) {
	$base_request = '{
		"id": "NULL",
		"cabinet_id": "'.$_GET["cabinet_id"].'",
		"invent_num": "'.$_GET["inv_num"].'",
	';

	foreach ($_GET as $key => $value) {
		if ($key == "add_wp_at_cab" || 
			$key == "cabinet_id"    ||
			$key == "inv_num") continue;

		$request = $base_request . '
			"workplace_id": "'.$value.'"
		}';
		echo $request;
		insert_into($link, "cabinet_workplaces", $request);
	}

	header("Location: add_data.php");
}
?>
<meta charset="utf-8">
<style>
	#open_license:checked ~ #license{
		display: block;
	}
	#license {
		display: none;
		padding-left: 20px;
	}
	#unlim:checked ~ #unlim_on {
		display: none;
	}
	#unlim_on {
		display: inline-block;
	}
	table {
		width: 100%;
		border-collapse: collapse;
	}
	table td {
		border-bottom: solid 1px black;
		box-sizing: border-box;
		padding-left: 50px;
	}
</style>
<table>
	<tr>
		<td>
			<h2>Добавить учебный предмет</h2>
			<form method="GET">
				<input type="text" name="name" placeholder="Название дисциплины"><br>
				<input type="submit" name="add_discipline" value="Добавить дисциплину">
			</form>
		</td>
		<td>
			<h2>Добавить программное обеспечение</h2>
			<form method="POST" enctype="multipart/form-data">
				<input type="text" name="name" placeholder="Название ПО"><br>
				<input type="text" name="ver" placeholder="Версия"><br>
				<input type="radio" name="type" value="free" checked="true">Свободное 
				<input type="radio" name="type" value="pay" id="open_license">Платное<br>
				<div id="license">
					<input type="text" name="l_name"   placeholder="Название лицензии"><br>
					Срок действия лицензии:<br>
					с: <input type="date" name="start_at"> 
					<input type="checkbox" name="unlim" id="unlim">бессрочно<br>
					по <input type="date" name="end_at" id="unlim_on">
						<br>
					<input type="text" name="doc_num"  placeholder="Номер договора"><br>
					Файл договора:<br>
					<input type="file" name="doc_link"><br>
				</div>

				<input type="submit" name="add_software" value="Добавить ПО">
			</form>
		</td>
	</tr>
	<tr>
		<td>
			<h2>Создать компьютерное рабочее место</h2>
			<form method="GET">
				<input type="text" name="name" placeholder="Название рабочего места"><br>
				Установленное ПО:<br>
				<?php
					$sql = "SELECT * FROM software";
					$result = mysqli_query($link, $sql);
					while ($row = mysqli_fetch_assoc($result)) {
						$ID = $row["id"];
						echo "<input type='checkbox' name='cb_$ID' value='$ID'>";
						echo $row['name'] . '<br>';
				    }
				?>
				<input type="submit" name="add_workplace" value="Добавить рабочее место">
			</form>
		</td>
		<td>
			<h2>Добавить учебный корпус</h2>
			<form method="GET">
				<input type="text" name="name" placeholder="Номенклатурное название"><br>
				<input type="text" name="liter" placeholder="Литера"><br>
				<input type="text" name="adress" placeholder="Адрес"><br>
				<input type="submit" name="add_corpus" value="Добавить корпус">
			</form>
		</td>
	</tr>
	<tr>
		<td>
			<h2>Добавить кабинет</h2>
			<form method="GET">
				<input type="text" name="name" placeholder="Номенклатурное название"><br>
				<input type="number" name="number" placeholder="Номер"><br>
				Корпус
				<select name="corpus_id">
					<?php
						$sql = "SELECT * FROM corpus";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							$ID = $row["id"];
							$liter = $row['liter'];
							echo "<option value='$ID'>$liter</option>";
					    }
					?>
				</select><br>
				Тип аудитории
				<select name="type">
					<option value="0">Аудитория для проведения лекционных занятий</option>
					<option value="1">Аудитория для проведения практических занятий</option>
					<option value="2">Лаборатория</option>
				</select><br>
				<input type="number" name="sit_count" placeholder="Количество посадочных мест студентов"><br>
				<input type="number" name="workplaces" placeholder="Количество рабочих мест студентов"><br>
				<input type="checkbox" name="lector_wp">Наличие рабочего места преподавателя<br>
				<input type="checkbox" name="whiteboard">Маркерная доска<br>
				<input type="checkbox" name="proector">Проекционное оборудование<br>
				<input type="checkbox" name="interactive">Интерактивная доска<br>
				<input type="submit" name="add_cabinet" value="Добавить кабинет">
			</form>
		</td>
		<td>
			<h2>Добавить рабочие места в кабинет</h2>
			<form method="GET">
				<input type="number" name="inv_num" placeholder="Инвентарный номер"><br>
				Кабинет
				<select name="cabinet_id">
					<?php
						$sql = "SELECT * FROM cabinets";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							$ID = $row["id"];
							$name = $row['name'];
							echo "<option value='$ID'>$name</option>";
					    }
					?>
				</select><br>
				Рабочие места:<br>
				<?php
					$sql = "SELECT * FROM workplaces
							LEFT JOIN (
								SELECT DISTINCT workplace_id FROM cabinet_workplaces
							) AS cab_wp
							ON workplaces.id = cab_wp.workplace_id
							WHERE cab_wp.workplace_id IS NULL";
					$result = mysqli_query($link, $sql);
					while ($row = mysqli_fetch_assoc($result)) {
						$ID = $row["id"];
						echo "<input type='checkbox' name='wp_$ID' value='$ID'>";
						echo $row['name'] . '<br>';
				    }
				?>
				<input type="submit" name="add_wp_at_cab" value="Добавить рабочие места в кабинет">
			</form>
		</td>
	</tr>
</table>
