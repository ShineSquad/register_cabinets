<table border='1' class='po-table'>
  	<tr>
    	<td>id</td>
    	<td>Дисциплина</td>
    	<td>Кабинет</td>
    	<td>✘</td>
  	</tr>
  	<?php
		$sql = "SELECT 
					report.*, 
					discipline.name AS d_name, 
					cabinets.number AS cabinet_num, 
					corpus.liter AS corpus_liter 
				FROM report
				INNER JOIN discipline ON report.discipline_id = discipline.id
				INNER JOIN cabinets ON report.cabinet_id = cabinets.id
				INNER JOIN corpus ON cabinets.corpus_id = corpus.id";

		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$name = $row['d_name'];
			$liter = $row['cabinet_num'] . $row["corpus_liter"];

			$remove = "php/remove_row.php?id=$id&table=report";

			$out = "<tr>
						<td>$id</td>
						<td>$name</td>
						<td>$liter</td>
						<td>
							<a href='$remove' class='rm_button'>✘</a>
						</td>
					</tr>";

			echo $out;
	    }
	?>
</table>