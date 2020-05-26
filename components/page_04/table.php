<table border='1' class='po-table'>
  	<tr>
    	<td>№</td>
    	<td>Название</td>
    	<td>Литера</td>
    	<td>Адрес</td>
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
				echo "<td>$adress</td>";
			echo "</tr>";
	    }
	?>
</table>