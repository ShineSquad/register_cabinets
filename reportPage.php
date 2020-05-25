<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php require "components/header-report.htm";?>
			<div class="main">
				<form class='container-reports' id='reportsForm' method="post">
				<select class='' name='subject' id='selectSubject'>
					<option disabled selected>Предмет</option>
				</select>
				<select class='' name='cabinet' id='selectCabinet'>
					<option disabled selected>Кабинет</option>
				</select>
				<select class='' name='software' id='selectSoftware'>
					<option disabled selected>Программное обеспечение</option>
				</select>
				<input type='submit' value='Сформировать' name="report">
			</form>
			</div>
		</div>
		<?php

			?>
	</body>
</html>

<?php
	function createReport() {
		require "debug/db_link.php";
		$sql = "SELECT * FROM report";
		$result = mysqli_query($link, $sql);
		$current_ID = -1;
		$cab_types = ["аудитория для проведения лекционных занятий", 
					"аудитория для проведения практических занятий", 
					"лаборатория"];
		$choise = ["×", "✓"];
		$data = array();
		$counter = -1;	
		$cab_counter = 0;

		while ($row = mysqli_fetch_assoc($result)) {
			$d_ID = $row["discipline_id"];
			if ($current_ID != $d_ID) {
				$counter++;

				$sql = "SELECT name FROM discipline WHERE id=$d_ID";
				$res = mysqli_query($link, $sql);
				$r = mysqli_fetch_assoc($res);

				$current_ID = $d_ID;
				
				$data[$counter]["discipline"] = array(
					"id"   => $d_ID,
					"name" => $r["name"]
				);
				$data[$counter]["cabinets"] = array();
				$cab_counter = 0;
			}

			$c_ID = $row["cabinet_id"];
			$sql = "SELECT * FROM cabinets WHERE id=$c_ID";
			$cres = mysqli_query($link, $sql);
			
			while ($r = mysqli_fetch_assoc($cres)) {
				$corpus_id = $r["corpus_id"];
				$sql = "SELECT liter FROM corpus WHERE id=$corpus_id";
				$liter_res = mysqli_query($link, $sql);
				$liter_r = mysqli_fetch_assoc($liter_res);
				$liter = $liter_r["liter"];

				$sql = "SELECT c.id AS 'cabinet_id', c.name AS 'cabinet_name', s.*, l.name AS 'l_name', l.doc_num
						FROM software s
						LEFT JOIN licenses l ON s.license_id = l.id
						JOIN workplace_software ws ON ws.software_id = s.id
						JOIN workplaces w ON w.id = ws.workplace_id
						JOIN cabinet_workplaces cw ON cw.workplace_id = w.id
						JOIN cabinets c ON c.id = cw.cabinet_id
						WHERE c.id = ".$r['id']."
						ORDER BY c.name";
				$sw = array();

				$cab_software = mysqli_query($link, $sql);
				while ($cs = mysqli_fetch_assoc($cab_software)) {
					$sw[] = $cs["name"];
				}

				$data[$counter]["cabinets"][$cab_counter] = array(
					"id"   => $r["id"],
					"name" => $r["name"],
					"type" => $cab_types[$r["type"]],
					"num"  => $r["number"] . $liter,
					"sit"  => $r["sit_place"],
					"wp"   => $r["workplaces"],
					"wb"   => $choise[$r["whiteboard"]],
					"l_wp" => $choise[$r["lector_wp"]],
					"pro"  => $choise[$r["proector"]],
					"int"  => $choise[$r["interactive"]],
					"sw"   => $sw
				);
			}	

			$cab_counter++;
		}

		// echo "<hr>";
		// printf("<pre>%s</pre>", print_r($data, true));

		echo "<table>";
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
									"\nрабочих мест: "                . $val["wp"] .
									"\nмаркерная доска: "             . $val["wb"] .
									"\nрабочее место преподавателя: " . $val["l_wp"] .
									"\nинтерактивная доска: "         . $val["int"] .
									"\nпроектор: "                    . $val["pro"];

					$software = implode("<br>", $val["sw"]);

					echo "<td>$cab_name_out</td>
						  <td>$cab_place_ct</td>
						  <td>$software</td>";
				echo "</tr>";
			}
		}
		echo "</table>";
		$counter++;

		require './phpword/vendor/autoload.php';

		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$phpWord -> setDefaultFontName('Time New Roman');
		$phpWord -> setDefaultFontSize(14);

		$properties = $phpWord -> getDocInfo();

		$properties->setCreator('My name');
		$properties->setCompany('My factory');
		$properties->setTitle('My title');
		$properties->setDescription('My description');
		$properties->setCategory('My category');
		$properties->setLastModifiedBy('My name');
		$properties->setCreated(mktime(0, 0, 0, 3, 12, 2014));
		$properties->setModified(mktime(0, 0, 0, 3, 14, 2014));
		$properties->setSubject('My subject');
		$properties->setKeywords('my, key, word');

		$sectionStyle = array(
		'orientation' => 'landscape',
		);
		$cellHCentered = array(
		'align' => 'center'
		);
		$cellVCentered = array(
		'valign' => 'center'
		);
		$styleTable = array(
		'borderSize' => 6, 
		'borderColor' => '999999',
		);

		$section = $phpWord -> addSection($sectionStyle);

		$section -> addText('Нижнетагильский государственный социально-педагогический институт (филиал) федерального государственного автономного образовательного учреждения высшего образования «Российский государственный профессионально-педагогический университет»', array(), $cellHCentered);

		$section -> addText('Справка', array('bold' => true), $cellHCentered);

		$year = date('Y');
		$text = 'о материально-техническом обеспечении основной образовательной программы высшего образования - программы бакалавриата 09.03.03 Прикладная информатика, профиль «Прикладная информатика в экономике», набор ' . $year;
		$section -> addText(htmlspecialchars($text), array('marginBottom' => 400), $cellHCentered);

		$phpWord->addTableStyle('Colspan Rowspan', $styleTable);
		$table = $section->addTable('Colspan Rowspan');
		$table->addRow(null, array('tblHeader' => true));
		$table->addCell(3000, $cellVCentered)->addText(
		'№ п\п', 
		array('bold' => true), 
		$cellHCentered
		);
		$table->addCell(3000, $cellVCentered) -> addText(
		'Наименование дисциплины (модуля), практик в соответствии с учебным планом', 
		array('bold' => true), 
		$cellHCentered
		);
		$table->addCell(3000, $cellVCentered) -> addText(
		'Наименование специальных* помещений и помещений для самостоятельной работы', 
		array('bold' => true), 
		$cellHCentered
		);
		$table->addCell(3000, $cellVCentered) -> addText(
		'Оснащенность специальных помещений и помещений для самостоятельной работы', 
		array('bold' => true), 
		$cellHCentered
		);
		$table->addCell(3000, $cellVCentered) -> addText(
		'Перечень лицензионного программного обеспечения. Реквизиты подтверждающего документа', 
		array('bold' => true), 
		$cellHCentered
		);
		 
		$table->addRow();
		$table->addCell(3000, $cellVCentered) -> addText(
			$counter, 
			null, 
			$cellHCentered
		);
		$table->addCell(3000, $cellVCentered) -> addText(
			$ds_name, 
			null, 
			$cellHCentered
		);
		$table->addCell(3000, $cellVCentered) -> addText(
			$cab_name_out, 
			null, 
			$cellHCentered
		);
		$table->addCell(3000, $cellVCentered) -> addText(
			$cab_place_ct, 
			null, 
			$cellHCentered
		);
		$table->addCell(3000, $cellVCentered) -> addText(
			$software, 
			null, 
			$cellHCentered
		);

		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter -> save('./documents/doc.docx');

		header('Location: ./reportPage.php');
	}

	if(array_key_exists('report',$_POST)){
		createReport();
	}
?>