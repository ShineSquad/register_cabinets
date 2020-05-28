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
	if ( isset($_GET["delete"]) ) {
		$id = $_GET["id"];
		$sql = "DELETE FROM corpus WHERE id=$id";

		$result = mysqli_query($link, $sql);
		if (!$result) {
			echo "Удалите данные из других таблиц";
		}
	}
?>