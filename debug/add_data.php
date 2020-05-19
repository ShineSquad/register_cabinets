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

	$JSON_software = '{
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
		$JSON_software .= ',
			"license_id": "'.mysqli_insert_id($link).'"
		';
	}

	$JSON_software .= '}';

	insert_into($link, "software", $JSON_software);

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
</style>

<h2>Добавить учебный предмет</h2>
<form method="GET">
	<input type="text" name="name" placeholder="Название дисциплины"><br>
	<input type="submit" name="add_discipline" value="Добавить дисциплину">
</form>

<hr>

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

<hr>

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