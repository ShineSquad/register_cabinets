<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php require "components/header-corpus.htm";?>
			<div class="main">
			  <div class='left-block'>
			    <table border='1' class='po-table'>
			      <tr>
			        <td>№</td>
			        <td>Название</td>
			        <td>Литера</td>
			        <td>Адрес</td>
			      </tr>
			    </table>
			  </div>
			  <div class='right-block'>
			    <form class='po-form' method="GET">
			     	<p class='form-title'>Добавить учебный корпус</p>
			     	<input type="text" name="name" placeholder="Номенклатурное название">
					<input type="text" name="liter" placeholder="Литера">
					<input type="text" name="adress" placeholder="Адрес">
					<input type="submit" name="add_corpus" value="Добавить корпус">
			    </form>
			  </div>
			</div>			
		</div>
	</body>
</html>

<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";

	if (isset($_GET["add_corpus"])) {
		insert_into($link, 
					"corpus",
					'{
						"id": "NULL",
						"name":   "'.$_GET["name"].'",
						"liter":  "'.$_GET["liter"].'",
						"adress": "'.$_GET["adress"].'"
					}');

		header("Location: corpusPage.php");
	}
?>