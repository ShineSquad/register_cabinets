<?php
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
	}
	if ( isset($_GET["delete"]) ) {
		$id = $_GET["id"];
		$sql = "DELETE FROM cabinets WHERE id=$id";

		$result = mysqli_query($link, $sql);
		if (!$result) {
			echo "Удалите данные из других таблиц";
		}
	}
?>