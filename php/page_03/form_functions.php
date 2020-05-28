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
	if ( isset($_GET["delete"]) ) {
		$id = $_GET["id"];
		$sql = "DELETE FROM discipline WHERE id=$id";

		$result = mysqli_query($link, $sql);
		if (!$result) {
			echo "Удалите данные из других таблиц";
		}
	}
?>