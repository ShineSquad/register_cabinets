<?php
	function createReport() {
		require './phpword/vendor/autoload.php';

		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$phpWord -> setDefaultFontName('Time New Roman');
		$phpWord -> setDefaultFontSize(14);

		$properties = $phpWord -> getDocInfo();

		$properties->setCreator('Niko');
		$properties->setCompany('ShineSquad');
		$properties->setTitle('Report');
		$properties->setDescription('This is my report');
		$properties->setCategory('My category');
		$properties->setLastModifiedBy('Niko');
		$properties->setCreated(mktime(0, 0, 0, 3, 12, 2014));
		$properties->setModified(mktime(0, 0, 0, 3, 14, 2014));
		$properties->setSubject('My subject');
		$properties->setKeywords('my, key, word');

		$cellRowContinue = array(
			'vMerge' => 'continue',
			'valign' => 'center'
		);
		$cellRowRestart = array(
			'vMerge' => 'restart',
			'valign' => 'center'
		);
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
		$table->addCell(1000, $cellVCentered)->addText(
		'№ п\п', 
		array('bold' => true), 
		$cellHCentered
		);
		$table->addCell(2000, $cellVCentered) -> addText(
		'Наименование дисциплины (модуля), практик в соответствии с учебным планом', 
		array('bold' => true), 
		$cellHCentered
		);
		$table->addCell(4000, $cellVCentered) -> addText(
		'Наименование специальных* помещений и помещений для самостоятельной работы', 
		array('bold' => true), 
		$cellHCentered
		);
		$table->addCell(5000, $cellVCentered) -> addText(
		'Оснащенность специальных помещений и помещений для самостоятельной работы', 
		array('bold' => true), 
		$cellHCentered
		);
		$table->addCell(4000, $cellVCentered) -> addText(
		'Перечень лицензионного программного обеспечения. Реквизиты подтверждающего документа', 
		array('bold' => true), 
		$cellHCentered
		);

		$data = get_report_data();
		$counter = 1;
		$old_counter = 1;
		foreach ($data as $key => $value) {
			$rowspan = count($value["cabinets"]);
			$ds_name = $value["discipline"]["name"];

			$first = true;
			foreach ($value["cabinets"] as $key => $val) {
					

					$cab_name_out = $val["type"] . " " . $val["name"] . " " . $val["num"];
					$cab_place_ct = "посадочных мест: "                 . $val["sit"] . 
									"\nрабочих мест: "                . $val["wp"] . 
									"\nмаркерная доска: "             . $val["wb"] .
									"\nрабочее место преподавателя: " . $val["l_wp"] .
									"\nинтерактивная доска: "         . $val["int"] .
									"\nпроектор: "                    . $val["pro"];
					$cab_place_ct = str_replace("\n", "<w:br/>", $cab_place_ct);

					$software = implode(", ", $val["sw"]);
					$table->addRow();
					if ($first) {
						$table->addCell(1000, $cellRowRestart) -> addText(
							$counter, 
							null, 
							$cellHCentered
						);
						$table->addCell(2000, $cellRowRestart) -> addText(
							$ds_name, 
							null, 
							$cellHCentered
						);
						$first = false; 
					} else {
						$table->addCell(1000, $cellRowContinue) -> addText(
							$counter, 
							null, 
							$cellHCentered
						);
						$table->addCell(2000, $cellRowContinue) -> addText(
							$ds_name, 
							null, 
							$cellHCentered
						);
					}
					$table->addCell(4000, $cellVCentered) -> addText(
						$cab_name_out, 
						null, 
						$cellHCentered
					);
					$table->addCell(5000) -> addText(
						$cab_place_ct, 
						null
					);
					$table->addCell(4000, $cellVCentered) -> addText(
						$software, 
						null, 
						$cellHCentered
					);
			}
			$counter++;
		}
		
		// $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		// $objWriter -> save('./documents/doc.docx');
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 
		header('Content-Disposition: attachment; filename="Отчёт.docx"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		
		ob_clean();
		$objWriter->save('php://output');
		exit;
	}
?>
