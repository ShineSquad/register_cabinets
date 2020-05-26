<?php
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