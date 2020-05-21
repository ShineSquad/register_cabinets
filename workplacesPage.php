<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";

	if (isset($_GET["add_workplace"])) {
		insert_into($link, 
					"workplaces",
					'{
						"id": "NULL",
						"name": "'.$_GET["name"].'"
					}');
		$wp_ID = mysqli_insert_id($link);

		foreach ($_GET as $key => $value) {
			if ($key == "add_workplace" || $key == "name") continue;
			insert_into($link,
						"workplace_software",
						'{
							"id":           "NULL",
							"workplace_id": "'.$wp_ID.'",
							"software_id":  "'.$value.'"
						}');
		}

		header("Location: workplacesPage.php");
	}
?>

<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php require "components/header-workplaces.htm";?>
			<div class="main">
			  <div class='left-block'>
			    <table border='1' class='po-table'>
			      <tr>
			        <td>№</td>
			        <td>Название рабочего места</td>
			        <td>Установленное ПО</td>
			      </tr>
			    </table>
			  </div>
			  <div class='right-block'>
			    <form class='po-form' method="GET">
			     	<p class='form-title'>Создать компьютерное рабочее место</p>
			     	<input type="text" name="name" placeholder="Название рабочего места"><br>
					Установленное ПО:<br>
					<?php
						$sql = "SELECT * FROM software";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							$ID = $row["id"];
							echo "<input type='checkbox' name='cb_$ID' value='$ID'>";
							echo $row['name'] . '<br>';
					    }
					?>
					<input type="submit" name="add_workplace" value="Добавить рабочее место">
			    </form>
			  </div>
			</div>			
		</div>
	</body>
</html>

