<table style="border-collapse: collapse;">
	<?php
		echo "<tr>
			  	<th>№ п/п</th>
			  	<th>Наименование дисциплины (модуля), практик в соответствии с учебным планом</th>
			  	<th>Наименование специальных* помещений и помещений для самостоятельной работы</th>
			  	<th>Оснащенность специальных помещений и помещений для самостоятельной работы</th>
			  	<th>Перечень лицензионного программного обеспечения. Реквизиты подтверждающего документа</th>
			  </tr>";
		$counter = 1;
		foreach ($data as $key => $value) {
			$rowspan = count($value["cabinets"]);
			$ds_name = $value["discipline"]["name"];

			$first = true;
			foreach ($value["cabinets"] as $key => $val) {
				echo "<tr>";
					if ($first) {
						echo "<td rowspan='$rowspan'>$counter</td>";
						echo "<td rowspan='$rowspan'>$ds_name</td>";
						$first = false;
					}
					$cab_name_out = $val["type"] . " " . $val["name"] . " " . $val["num"];
					$cab_place_ct = "посадочных мест: "                 . $val["sit"] . 
									"<br>рабочих мест: "                . $val["wp"] .
									"<br>маркерная доска: "             . $val["wb"] .
									"<br>рабочее место преподавателя: " . $val["l_wp"] .
									"<br>интерактивная доска: "         . $val["int"] .
									"<br>проектор: "                    . $val["pro"];

					$software = implode(", ", $val["sw"]);

					echo "<td>$cab_name_out</td>
						  <td>$cab_place_ct</td>
						  <td>$software</td>";
				echo "</tr>";
			}
			$counter++;
		}
	?>
</table>