<table border='1' class='po-table'>
  	<tr>
    	<td>№</td>
    	<td>Название рабочего места</td>
    	<td>Установленное ПО</td>
  	</tr>
  	<?php
		$sql = "SELECT * FROM workplaces";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$name = $row['name'];
			echo "<tr>";
				echo "<td>$id</td>";
				echo "<td>$name</td>";
				echo "<td>";
					$sql = "SELECT software.name FROM workplace_software
							LEFT JOIN software
							ON software.id = workplace_software.software_id
							WHERE workplace_software.workplace_id = $id";
					$sub_res = mysqli_query($link, $sql);
					while ($r = mysqli_fetch_assoc($sub_res)) {
						echo $r["name"] . "<br>";
					}
				echo "</td>";
			echo "</tr>";
	    }
	?>
</table>