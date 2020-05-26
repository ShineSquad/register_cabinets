<?php
	if (isset($_GET["add_corpus"])) {
		insert_into($link, 
					"corpus",
					'{
						"id": "NULL",
						"name":   "'.$_GET["name"].'",
						"liter":  "'.$_GET["liter"].'",
						"adress": "'.$_GET["adress"].'"
					}');
	}
?>