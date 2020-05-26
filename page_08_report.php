<?php
	require "php/page_08/get_report_data.php";
	$data = get_report_data();
	
	if(array_key_exists('report',$_POST)){
		require "php/page_08/create_report.php";
		createReport();
	}
?>
<?php require "components/head.htm";?>
<body>
	<div id="app">
		<?php $p=7; require "components/navigation.php";?>
		<div class="main">
			<form class='container-reports' id='reportsForm' method="POST">
				<input type='submit' value='Сформировать' name="report">
			</form>
			<?php require "components/page_08/table.php"?>
		</div>
	</div>
</body>

