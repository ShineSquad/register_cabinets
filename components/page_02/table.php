<table border='1' class='po-table'>
 	<tr>
    	<td>id</td>
    	<td>Номер</td>
    	<td>Количество посадочных мест</td>
    	<td>Количество рабочих мест</td>
    	<td>Имеющееся оборудование</td>
    	<td>✘</td>
  	</tr>
  <?php
		$sql = "SELECT cabinets.*, corpus.name AS corpus_name, corpus.liter AS corpus_liter 
				FROM cabinets
				INNER JOIN corpus ON cabinets.corpus_id = corpus.id";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$number = $row['number'] . $row["corpus_liter"];
			$sit_place = $row['sit_place'];
			$workplaces = $row['workplaces'];

			$lector_wp = $row['lector_wp'];
			$whiteboard = $row['whiteboard'];
			$proector = $row['proector'];
			$interactive = $row['interactive'];

			$choise = ["×", "✓"];

			$remove = "php/remove_row.php?id=$id&table=cabinets";

			$out = "<tr>
						<td>$id</td>
						<td>$number</td>
						<td>$sit_place</td>
						<td>$workplaces</td>
						<td>
							<p>Рабочее место преподавателя: $choise[$lector_wp]</p>
							<p>Маркерная доска: $choise[$whiteboard]</p>
							<p>Проекционное оборудование: $choise[$proector]</p>
							<p>Интерактивная доска: $choise[$interactive]</p>
						</td>
						<td>
							<a href='$remove' class='rm_button'>✘</a>
						</td>
					</tr>";

			echo $out;
	    }
	?>
</table>