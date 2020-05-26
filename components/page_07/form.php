<form class='po-form' method="GET">
 	<p class='form-title'>Добавить кабинеты к предмету</p>
 	<select name="discipline_id">
		<?php
			$sql = "SELECT * FROM discipline";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_assoc($result)) {
				$ID = $row["id"];
				$name = $row['name'];
				echo "<option value='$ID'>$name</option>";
		    }
		?>
	</select><br>
	<?php
		$sql = "SELECT * FROM cabinets";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$ID = $row["id"];
			$name = $row['name'];
			echo "<input type='checkbox' name='cid_$ID' value='$ID'>$name<br>";
	    }
	?>
	<input type="submit" name="add_cab_to_disc" value="Добавить кабинеты к предмету">
</form>