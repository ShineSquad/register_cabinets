<form class='po-form' method="GET">
 	<p class='form-title'>Добавить кабинет</p>
	<input type="text" required name="name" placeholder="Номенклатурное название"><br>
	<input type="number" required name="number" placeholder="Номер"><br>
	Корпус
	<select name="corpus_id">
		<?php
			$sql = "SELECT * FROM corpus";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_assoc($result)) {
				$ID = $row["id"];
				$liter = $row['liter'];
				echo "<option value='$ID'>$liter</option>";
		    }
		?>
	</select><br>
	Тип аудитории
	<select name="type">
		<option value="0">Аудитория для проведения лекционных занятий</option>
		<option value="1">Аудитория для проведения практических занятий</option>
		<option value="2">Лаборатория</option>
	</select><br>
	<input type="number" required name="sit_count" placeholder="Количество посадочных мест студентов"><br>
	<input type="number" required name="workplaces" placeholder="Количество рабочих мест студентов"><br>
	<input type="checkbox" name="lector_wp">Наличие рабочего места преподавателя<br>
	<input type="checkbox" name="whiteboard">Маркерная доска<br>
	<input type="checkbox" name="proector">Проекционное оборудование<br>
	<input type="checkbox" name="interactive">Интерактивная доска<br>
	<input type="submit" name="add_cabinet" value="Добавить кабинет">
</form>