<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";

	if (isset($_GET["add_cab_to_disc"])) {
		$dID = $_GET["discipline_id"];
		foreach ($_GET as $key => $value) {
			if ($key == "discipline_id" || 
				$key == "add_cab_to_disc") continue;

			$request = '{
				"id": "NULL",
				"discipline_id": "'.$dID.'",
				"cabinet_id": "'.$value.'"
			}';
			echo $request;
			insert_into($link, "report", $request);
		}

		header("Location: cabinetToSubjectPage.php");
	}
?>

<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php require "components/header-cabinetToSubject.htm";?>
			<div class="main">
			  <div class='left-block'>
			    <table border='1' class='po-table'>
			      	<tr>
			        	<td>№</td>
			        	<td>Кабинет</td>
			        	<td>Дисциплина</td>
			      	</tr>
			      	<?php
						$sql = "SELECT * FROM corpus";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							$id = $row['id'];
							$name = $row['name'];
							$liter = $row['liter'];
							$adress = $row['adress'];
							echo "<tr>";
								echo "<td>$id</td>";
								echo "<td>$name</td>";
								echo "<td>$liter</td>";
							echo "</tr>";
					    }
					?>
			    </table>
			  </div>
			  <div class='right-block'>
			    <form class='po-form' method="GET">
			     	<p class='form-title'>Добавить кабинеты к предмету</p>
			     	<select name="discipline_id">
						<?php
							$sql = "SELECT * FROM discipline";
							$result = mysqli_query($link, $sql);
							while ($row = mysqli_fetch_assoc($result)) {
								$ID = $row["id"];
								$name = $row['name'];
								echo "<option value='$ID'>$name</option>";
						    }
						?>
					</select><br>
					<?php
						$sql = "SELECT * FROM cabinets";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							$ID = $row["id"];
							$name = $row['name'];
							echo "<input type='checkbox' name='cid_$ID' value='$ID'>$name<br>";
					    }
					?>
					<input type="submit" name="add_cab_to_disc" value="Добавить кабинеты к предмету">
			    </form>
			  </div>
			</div>			
		</div>
	</body>
</html>