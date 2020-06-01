<table border='1' class='po-table'>
    <tr>
      	<td>id</td>
        <td>Название ПО</td>
        <td>Версия</td>
        <td>Тип</td>
        <td>Название лицензии</td>
        <td>Номер договора</td>
        <td>✘</td>
    </tr>
  	<?php
		$sql = "SELECT software.*, licenses.name as 'l_name', licenses.doc_num 
				FROM software
				LEFT JOIN licenses
				ON software.license_id = licenses.id";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$name = $row['name'];	
			$version = $row['version'];
			$type = $row['type'];
			$l_name = $row['l_name'];
			$l_num = $row['doc_num'];

			$remove = "php/remove_row.php?id=$id&table=software";

			$out = "<tr>
						<td>$id</td>
						<td>$name</td>
						<td>$version</td>
						<td>$type</td>
						<td>$l_name</td>
						<td>$l_num</td>
						<td>
							<a href='$remove' class='rm_button'>✘</a>
						</td>
					</tr>";

			echo $out;
	    }
	?>
</table>