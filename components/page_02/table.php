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