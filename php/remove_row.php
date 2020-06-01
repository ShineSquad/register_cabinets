<?php
$headers = array(
	"software"           => "../page_01_software.php",
	"cabinets"           => "../page_02_cabinets.php",
	"discipline"         => "../page_03_discipline.php",
	"corpus"             => "../page_04_corpuses.php",
	"workplaces"         => "../page_05_workplaces.php",
	"cabinet_workplaces" => "../page_06_wp_in_cabinet.php",
	"report"             => "../page_07_cab_to_discipline.php"
);
if (isset($_GET["table"])) {
	require "../debug/db_link.php";

	$id = $_GET["id"];
	$t  = $_GET["table"];

	$sql = "DELETE FROM $t WHERE id=$id";

	mysqli_query($link, $sql);
	// echo $sql;

	$h = $headers[$t];
	header("Location: $h");
}
?>