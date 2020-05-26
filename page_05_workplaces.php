<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";

	require "php/page_05/form_functions.php";
?>

<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php $p=4; require "components/navigation.php";?>
			<div class="main">
			  <div class='left-block'>
			    <?php require "components/page_05/table.php"?>
			  </div>
			  <div class='right-block'>
			    <?php require "components/page_05/form.php"?>
			  </div>
			</div>			
		</div>
	</body>
</html>

