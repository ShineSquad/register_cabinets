<table border='1' class='po-table'>
  	<tr>
    	<td>id</td>
    	<td>Название рабочего места</td>
    	<td>Установленное ПО</td>
    	<td>✘</td>
  	</tr>
  	<?php
		$sql = "SELECT * FROM workplaces";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$name = $row['name'];

			$remove = "php/remove_row.php?id=$id&table=workplaces";

			$software = "";
			$sql = "SELECT software.name FROM workplace_software
					LEFT JOIN software
					ON software.id = workplace_software.software_id
					WHERE workplace_software.workplace_id = $id";
			$sub_res = mysqli_query($link, $sql);
			while ($r = mysqli_fetch_assoc($sub_res)) {
				$software .= $r["name"] . "<br>";
			}

			$out = "<tr>
						<td>$id</td>
						<td>$name</td>
						<td>$software</td>
						<td>
							<a href='$remove' class='rm_button'>✘</a>
						</td>
					</tr>";

			echo $out;
	    }
	?>
</table>