<?php
$user = "root";
$pass = "";
$host = "localhost";
$name = "NTGSPI_cabinets";

$link = mysqli_connect($host, $user, $pass, $name);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
mysqli_set_charset($link, "utf8");
?>