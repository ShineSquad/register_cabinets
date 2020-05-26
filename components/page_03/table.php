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