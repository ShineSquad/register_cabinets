<table border='1' class='po-table'>
  	<tr>
    	<td>id</td>
    	<td>Название</td>
    	<td>Литера</td>
    	<td>Адрес</td>
    	<td>✘</td>
  	</tr>
  	<?php
		$sql = "SELECT * FROM corpus";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$name = $row['name'];
			$liter = $row['liter'];
			$adress = $row['adress'];

			$remove = "php/remove_row.php?id=$id&table=corpus";

			$out = "<tr>
						<td>$id</td>
						<td>$name</td>
						<td>$liter</td>
						<td>$adress</td>
						<td>
							<a href='$remove' class='rm_button'>✘</a>
						</td>
					</tr>";

			echo $out;
	    }
	?>
</table>