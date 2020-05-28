<table border='1' class='po-table'>
  	<tr>
    	<td>№</td>
    	<td>Кабинет</td>
    	<td>Дисциплина</td>
  	</tr>
  	<?php
		$sql = "SELECT * FROM report";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$name = $row['discipline_id'];
			$liter = $row['cabinet_id'];
			echo "<tr>";
				echo "<td>$id</td>";
				echo "<td>$name</td>";
				echo "<td>$liter</td>";
				echo "<td>
						<form method='GET'>
							<input type='text' name='id' value='$id' style='display: none'>
							<input type='submit' name='delete' value='Удалить'>
						</form>
					  </td>";
			echo "</tr>";
	    }
	?>
</table>