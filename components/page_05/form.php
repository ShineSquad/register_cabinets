<form class='po-form' method="GET">
 	<p class='form-title'>Создать компьютерное рабочее место</p>
 	<input type="text" name="name" required placeholder="Название рабочего места"><br>
	Установленное ПО:<br>
	<?php
		$sql = "SELECT * FROM software";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$ID = $row["id"];
			echo "<input type='checkbox' name='cb_$ID' value='$ID'>";
			echo $row['name'] . '<br>';
	    }
	?>
	<input type="submit" name="add_workplace" value="Добавить рабочее место">
</form>