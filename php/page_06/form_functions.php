<?php
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
			insert_into($link, "cabinet_workplaces", $request);
		}
	}
?>