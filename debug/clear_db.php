<?php
$tables = ["report",
		   "workplace_software",
		   "software",
		   "licenses",
		   "cabinet_workplaces",
		   "workplaces",
		   "cabinets",
		   "corpus",
		   "discipline"];
require "db_link.php";

if (isset($_GET["delete_tables"])) {
	foreach ($tables as $key => $value) {
		$sql = "DROP TABLE $value";
		mysqli_query($link, $sql);
	}

	header("Location: clear_db.php");
}

if (isset($_GET["clear_tables"])) {
	foreach ($tables as $key => $value) {
		$sql = "DELETE FROM $value";
		mysqli_query($link, $sql);
	}

	header("Location: clear_db.php");
}

?>
<form method="GET">
	<input type="submit" name="delete_tables" value="Delete tables">
</form>
<form method="GET">
	<input type="submit" name="clear_tables" value="Clear tables">
</form>