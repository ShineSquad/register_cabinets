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
?>