<?php
	if (isset($_GET["add_discipline"])) {
		$name = $_GET["name"];
		insert_into($link, 
					"discipline", 
					'{
						"id": "NULL",
						"name": "'.$name.'"
					}');
	}
?>