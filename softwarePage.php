<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php require "components/header-software.htm";?>
			<div class="main">
			  <div class='left-block'>
			    <table border='1' class='po-table'>
			      <tr>
			        <td>№</td>
			        <td>Название ПО</td>
			        <td>Версия</td>
			        <td>Название лицензии</td>
			        <td>Номер договора</td>
			      </tr>
			    </table>
			  </div>
			  <div class='right-block'>
			    <form class='po-form' method="POST" enctype="multipart/form-data">
			      	<p class='form-title'>Добавить программное обеспечение</p>
			      	<input type="text" name="name" placeholder="Название ПО"><br>
					<input type="text" name="ver" placeholder="Версия"><br>
					<input type="radio" name="type" value="free" checked="true">Свободное 
					<input type="radio" name="type" value="pay" id="open_license">Платное<br>
					<div id="license">
						<input type="text" name="l_name" placeholder="Название лицензии"><br>
						Срок действия лицензии:<br>
						<div class="license-date">
							с: <input type="date" name="start_at"> 
							<input type="checkbox" name="unlim" id="unlim">бессрочно<br>
							<div id="unlim_on">
								по: <input type="date" name="end_at">
							</div>
						</div>
						<input type="text" name="doc_num"  placeholder="Номер договора"><br>
						<div class="file-block">
							Файл договора:<br>
							<div class="custom-input">
								<div class="form-group">
								    <input type="file" name="doc_link" id="file" class="input-file">
								    <label for="file" class="btn btn-tertiary js-labelFile">
								      	<i class="icon fa fa-check"></i>
								      	<span class="js-fileName">Загрузить файл</span>
								    </label>
								</div>
							</div>
						</div>
					</div>
			      	<input type="submit" name="add_software" value="Добавить ПО">
			    </form>
			  </div>
			</div>
		</div>
	</body>
</html>

<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";

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

		header("Location: softwarePage.php");
	}
?>