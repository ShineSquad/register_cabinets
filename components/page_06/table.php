<table border='1' class='po-table'>
  	<tr>
    	<td>id</td>
    	<td>Инвентарный номер</td>
    	<td>Кабинет</td>
    	<td>Рабочие места</td>
    	<td>✘</td>
  	</tr>
  	<?php
		$sql = "SELECT 
					cabinet_workplaces.*, 
					cabinets.number AS cabinet_num, 
					corpus.liter AS corpus_liter, 
					workplaces.name AS wp_name
			FROM cabinet_workplaces
			INNER JOIN cabinets ON cabinet_workplaces.cabinet_id = cabinets.id
			INNER JOIN corpus ON cabinets.corpus_id = corpus.id
			INNER JOIN workplaces ON cabinet_workplaces.workplace_id = workplaces.id
			";
		
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$cabinet_id = $row['cabinet_num'] . $row['corpus_liter'];
			$workplace_id = $row['wp_name'];
			$invent_num = $row['invent_num'];

			$remove = "php/remove_row.php?id=$id&table=cabinet_workplaces";

			$out = "<tr>
						<td>$id</td>
						<td>$invent_num</td>
						<td>$cabinet_id</td>
						<td>$workplace_id</td>
						<td>
							<a href='$remove' class='rm_button'>✘</a>
						</td>
					</tr>";

			echo $out;
	    }
	?>
</table>