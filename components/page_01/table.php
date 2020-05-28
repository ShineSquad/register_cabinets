<table border='1' class='po-table'>
    <tr>
      	<td>№</td>
        <td>Название ПО</td>
        <td>Версия</td>
        <td>Тип</td>
        <td>Название лицензии</td>
        <td>Номер договора</td>
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
			echo "<tr>";
				echo "<td>$id</td>";
				echo "<td>$name</td>";
				echo "<td>$version</td>";
				echo "<td>$type</td>";
				echo "<td>$l_name</td>";
				echo "<td>$l_num</td>";
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