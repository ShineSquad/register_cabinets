<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";
	
	if (isset($_GET["add_wp_at_cab"])) {
		$base_request = '{
			"id": "NULL",
			"cabinet_id": "'.$_GET["cabinet_id"].'",
			"invent_num": "'.$_GET["inv_num"].'",
		';

		foreach ($_GET as $key => $value) {
			if ($key == "add_wp_at_cab" || 
				$key == "cabinet_id"    ||
				$key == "inv_num") continue;

			$request = $base_request . '
				"workplace_id": "'.$value.'"
			}';
			//echo $request;
			insert_into($link, "cabinet_workplaces", $request);
		}

		//header("Location: cabinetWorkplacePage.php");
	}
?>

<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php require "components/header-cabinet-workplace.htm";?>
			<div class="main">
			  <div class='left-block'>
			    <table border='1' class='po-table'>
			      	<tr>
			        	<td>№</td>
			        	<td>Инвентарный номер</td>
			        	<td>Кабинет</td>
			        	<td>Рабочие места</td>
			      	</tr>
			      	<?php
						$sql = "SELECT * FROM cabinet_workplaces";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							$id = $row['id'];
							$cabinet_id = $row['cabinet_id'];
							$workplace_id = $row['workplace_id'];
							$invent_num = $row['invent_num'];
							echo "<tr>";
								echo "<td>$id</td>";
								echo "<td>$cabinet_id</td>";
								echo "<td>$workplace_id</td>";
								echo "<td>$invent_num</td>";
							echo "</tr>";
					    }
					?>
			    </table>
			  </div>
			  <div class='right-block'>
			    <form class='po-form' method="GET">
			     	<p class='form-title'>Добавить рабочие места в кабинет</p>
			     	<input type="number" required name="inv_num" placeholder="Инвентарный номер"><br>
					Кабинет
					<select name="cabinet_id">
						<?php
							$sql = "SELECT * FROM cabinets";
							$result = mysqli_query($link, $sql);
							while ($row = mysqli_fetch_assoc($result)) {
								$ID = $row["id"];
								$name = $row['name'];
								echo "<option value='$ID'>$name</option>";
						    }
						?>
					</select><br>
					Рабочие места:<br>
					<?php
						$sql = "SELECT * FROM workplaces
								LEFT JOIN (
									SELECT DISTINCT workplace_id FROM cabinet_workplaces
								) AS cab_wp
								ON workplaces.id = cab_wp.workplace_id
								WHERE cab_wp.workplace_id IS NULL";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							$ID = $row["id"];
							echo "<input type='checkbox' name='wp_$ID' value='$ID'>";
							echo $row['name'] . '<br>';
					    }
					?>
					<input type="submit" name="add_wp_at_cab" value="Добавить рабочие места в кабинет">
			    </form>
			  </div>
			</div>			
		</div>
	</body>
</html>
