<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>register</title>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.1.3/vue-router.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue-form/0.3.1/vue-form.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.12.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.12.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.12.0/firebase-database.js"></script>
    <script
      src="https://code.jquery.com/jquery-3.5.0.js"
      integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc="
      crossorigin="anonymous">
    </script>


    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/header.css">
    <link rel="stylesheet" href="./styles/main.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  </head>
  <body>
    <div id="app">
      <header>
        <router-link class="link" to="/software" active-class="active-link" onclick="getSoftware()">Программное обеспечение</router-link>
  			<router-link class="link" to="/cabinets" active-class="active-link" onclick="getCabinet()">Кабинеты</router-link>
  			<router-link class="link" to="/subjects" active-class="active-link" onclick="getSubjects()">Предметы</router-link>
  			<router-link class="link" to="/reports" active-class="active-link" onclick="getDataReport()">Отчёты</router-link>
      </header>

      <router-view class="main"></router-view>
    </div>
    <?php
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
        'Наименование дисциплины (модуля), практик в соответсвии с учебным планом', 
        array('bold' => true), 
        $cellHCentered
      );
      $table->addCell(3000, $cellVCentered) -> addText(
        'Наименование специальных* помещений и помещений для самостоятельной работы', 
        array('bold' => true), 
        $cellHCentered
      );
      $table->addCell(3000, $cellVCentered) -> addText(
        'Оснащенность спецальных помещений и помещений для самостоятельной работы', 
        array('bold' => true), 
        $cellHCentered
      );
      $table->addCell(3000, $cellVCentered) -> addText(
        'Перечень лицензионного программного обеспечения. Реквизиты подтверждающего документа', 
        array('bold' => true), 
        $cellHCentered
      );
       
      $table->addRow();
      $table->addCell(3000, $cellVCentered) -> addText('E', null, $cellHCentered);
      $table->addCell(3000, $cellVCentered) -> addText('E', null, $cellHCentered);
      $table->addCell(3000, $cellVCentered) -> addText('Т', null, $cellHCentered);
      $table->addCell(3000, $cellVCentered) -> addText('E', null, $cellHCentered);
      $table->addCell(3000, $cellVCentered) -> addText('E', null, $cellHCentered);

      $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
      $objWriter -> save('./documents/doc.docx');
    ?>
    <script type="text/javascript" src="./scripts/script.js"></script>
  </body>
</html>
