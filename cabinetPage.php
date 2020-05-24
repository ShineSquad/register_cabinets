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
			        	<td>Количество посадочных мест</td>
			        	<td>Количество рабочих мест</td>
			        	<td>Имеющееся оборудование</td>
			      	</tr>
			      <?php
						$sql = "SELECT * FROM cabinets";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							$id = $row['id'];
							$number = $row['number'];
							$corpus_id = $row['corpus_id'];
							$sit_place = $row['sit_place'];
							$workplaces = $row['workplaces'];

							$lector_wp = $row['lector_wp'];
							$whiteboard = $row['whiteboard'];
							$proector = $row['proector'];
							$interactive = $row['interactive'];

							$choise = ["×", "✓"];
							echo "<tr>";
								echo "<td>$id</td>";
								echo "<td>$number</td>";
								echo "<td>$corpus_id</td>";
								echo "<td>$sit_place</td>";
								echo "<td>$workplaces</td>";
								echo "<td>
										<p>Рабочее место преподавателя: $choise[$lector_wp]</p>
										<p>Маркерная доска: $choise[$whiteboard]</p>
										<p>Проекционное оборудование: $choise[$proector]</p>
										<p>Интерактивная доска: $choise[$interactive]</p>
									  </td>";
							echo "</tr>";
					    }
					?>
			    </table>
			  </div>
			  <div class='right-block'>
			    <form class='po-form' method="GET">
			     	<p class='form-title'>Добавить кабинет</p>
					<input type="text" required name="name" placeholder="Номенклатурное название"><br>
					<input type="number" required name="number" placeholder="Номер"><br>
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
					<input type="number" required name="sit_count" placeholder="Количество посадочных мест студентов"><br>
					<input type="number" required name="workplaces" placeholder="Количество рабочих мест студентов"><br>
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