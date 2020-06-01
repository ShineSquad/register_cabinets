<table border='1' class='po-table'>
  	<tr>
    	<td>id</td>
    	<td>Название</td>
    	<td>✘</td>
  	</tr>
  	<?php
		$sql = "SELECT * FROM discipline";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
			$name = $row['name'];

			$remove = "php/remove_row.php?id=$id&table=discipline";

			$out = "<tr>
						<td>$id</td>
						<td>$name</td>
						<td>
							<a href='$remove' class='rm_button'>✘</a>
						</td>
					</tr>";

			echo $out;
	    }
	?>
</table>