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