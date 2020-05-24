<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";

	if (isset($_GET["add_discipline"])) {
		$name = $_GET["name"];
		insert_into($link, 
					"discipline", 
					'{
						"id": "NULL",
						"name": "'.$name.'"
					}');

		header("Location: subjectPage.php");
	}
?>

<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php require "components/header-subject.htm";?>
			<div class="main">
			  <div class='left-block'>
			    <table border='1' class='po-table'>
			      	<tr>
			        	<td>№</td>
			        	<td>Название</td>
			      	</tr>
			      	<?php
						$sql = "SELECT * FROM discipline";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							$id = $row['id'];
							$name = $row['name'];
							echo "<tr>";
								echo "<td>$id</td>";
								echo "<td>$name</td>";
							echo "</tr>";
					    }
					?>
			    </table>
			  </div>
			  <div class='right-block'>
			    <form class='po-form' method="GET">
			      <p class='form-title'>Добавить учебный предмет</p>
			      <input type='text' required name="name" placeholder='Название дисциплины'>
			      <input type='submit' name="add_discipline" value='Добавить дисциплину'>
			    </form>
			  </div>
			</div>
		</div>
	</body>
</html>