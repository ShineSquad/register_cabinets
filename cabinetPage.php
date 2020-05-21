<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php require "components/header-cabinet.htm";?>
			<div class="main">
			  <div class='left-block'>
			    <table border='1' class='po-table'>
			      <tr>
			        <td>№</td>
			        <td>Номер</td>
			        <td>Корпус</td>
			        <td>Количество мест</td>
			        <td>Доска</td>
			        <td>Место преподавателя</td>
			      </tr>
			    </table>
			  </div>
			  <div class='right-block'>
			    <form class='po-form' method="GET">
			     	<p class='form-title'>Добавить кабинет</p>
					<input type="text" name="name" placeholder="Номенклатурное название"><br>
					<input type="number" name="number" placeholder="Номер"><br>
					Корпус
					<select name="corpus_id">
						<?php
							$sql = "SELECT * FROM corpus";
							$result = mysqli_query($link, $sql);
							while ($row = mysqli_fetch_assoc($result)) {
								$ID = $row["id"];
								$liter = $row['liter'];
								echo "<option value='$ID'>$liter</option>";
						    }
						?>
					</select><br>
					Тип аудитории
					<select name="type">
						<option value="0">Аудитория для проведения лекционных занятий</option>
						<option value="1">Аудитория для проведения практических занятий</option>
						<option value="2">Лаборатория</option>
					</select><br>
					<input type="number" name="sit_count" placeholder="Количество посадочных мест студентов"><br>
					<input type="number" name="workplaces" placeholder="Количество рабочих мест студентов"><br>
					<input type="checkbox" name="lector_wp">Наличие рабочего места преподавателя<br>
					<input type="checkbox" name="whiteboard">Маркерная доска<br>
					<input type="checkbox" name="proector">Проекционное оборудование<br>
					<input type="checkbox" name="interactive">Интерактивная доска<br>
					<input type="submit" name="add_cabinet" value="Добавить кабинет">
			    </form>
			  </div>
			</div>
		</div>
	</body>
</html>

<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";

	if (isset($_GET["add_cabinet"])) {
		$request = '{
			"id": "NULL",
			"name": "'      .$_GET["name"]     .'",
			"number": "'    .$_GET["number"]   .'",
			"corpus_id": "' .$_GET["corpus_id"].'",
			"type": "'      .$_GET["type"]     .'",
			"sit_place": "' .$_GET["sit_count"].'",
			"workplaces": "'.$_GET["workplaces"].'",
		';

		$lector_wp   = 0;
		$whiteboard  = 0;
		$proector    = 0;
		$interactive = 0;
		
		if (isset($_GET["lector_wp"]))   $lector_wp   = 1;
		if (isset($_GET["whiteboard"]))  $whiteboard  = 1;
		if (isset($_GET["proector"]))    $proector    = 1;
		if (isset($_GET["interactive"])) $interactive = 1;
		
		$request .= '
			"lector_wp": "'  .$lector_wp.'",
			"whiteboard": "' .$whiteboard.'",
			"proector": "'   .$proector.'",
			"interactive": "'.$interactive.'"
		}';

		insert_into($link, "cabinets", $request);

		header("Location: cabinetPage.php");
	}
?>