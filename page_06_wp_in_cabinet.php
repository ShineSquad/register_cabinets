<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";
	
	require "php/page_06/form_functions.php";
?>

<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php $p=5; require "components/navigation.php";?>
			<div class="main">
			  <div class='left-block'>
			    <?php require "components/page_06/table.php"?>
			  </div>
			  <div class='right-block'>
			    <?php require "components/page_06/form.php"?>
			  </div>
			</div>			
		</div>
	</body>
</html>
