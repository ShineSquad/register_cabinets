<form class='po-form' method="GET">
 	<p class='form-title'>Добавить рабочие места в кабинет</p>
 	<input type="number" required name="inv_num" placeholder="Инвентарный номер"><br>
	Кабинет
	<select name="cabinet_id">
		<?php
			$sql = "SELECT * FROM cabinets";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_assoc($result)) {
				$ID = $row["id"];
				$name = $row['name'];
				echo "<option value='$ID'>$name</option>";
		    }
		?>
	</select><br>
	Рабочие места:<br>
	<?php
		$sql = "SELECT * FROM workplaces
				LEFT JOIN (
					SELECT DISTINCT workplace_id FROM cabinet_workplaces
				) AS cab_wp
				ON workplaces.id = cab_wp.workplace_id
				WHERE cab_wp.workplace_id IS NULL";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$ID = $row["id"];
			echo "<input type='checkbox' name='wp_$ID' value='$ID'>";
			echo $row['name'] . '<br>';
	    }
	?>
	<input type="submit" name="add_wp_at_cab" value="Добавить рабочие места в кабинет">
</form>