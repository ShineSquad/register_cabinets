<?php
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
	}
	if ( isset($_GET["delete"]) ) {
		$id = $_GET["id"];
		$sql = "DELETE FROM software WHERE id=$id";

		$result = mysqli_query($link, $sql);
		if (!$result) {
			echo "Удалите данные из других таблиц";
		}
	}
?>