<?php
	function insert_into($db_link, $t_name, $JSON_columns) {
		$JSON = json_decode($JSON_columns, true);
		
		$columns = "(";
		$_values = "(";

		foreach ($JSON as $key => $value) {
			if ($value != "NULL" && !is_numeric($value)) $value = "'$value'";

			$columns .= $key . ", ";
			$_values .= $value . ", ";
		}

		$columns = substr($columns, 0, -2) . ")";
		$_values = substr($_values, 0, -2) . ")";

		$sql = "INSERT INTO $t_name $columns VALUES $_values";

		//echo $sql;
		mysqli_query($db_link, $sql);
	}
?>