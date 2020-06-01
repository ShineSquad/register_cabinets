<?php
	if (isset($_GET["add_cab_to_disc"])) {
		$dID = $_GET["discipline_id"];
		foreach ($_GET as $key => $value) {
			if ($key == "discipline_id" || 
				$key == "add_cab_to_disc") continue;

			$request = '{
				"id": "NULL",
				"discipline_id": "'.$dID.'",
				"cabinet_id": "'.$value.'"
			}';

			insert_into($link, "report", $request);
		}
	}
	if ( isset($_GET["delete"]) ) {
		$id = $_GET["id"];
		$sql = "DELETE FROM report WHERE id=$id";

		$result = mysqli_query($link, $sql);
		if (!$result) {
			echo "Удалите данные из других таблиц";
		}
	}
?>