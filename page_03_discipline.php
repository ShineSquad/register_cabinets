<?php
	require "debug/sql_functions.php";
	require "debug/db_link.php";

	require "php/page_03/form_functions.php";
?>

<!DOCTYPE html>
<html>
	<?php require "components/head.htm";?>
	<body>
		<div id="app">
			<?php $p=2; require "components/navigation.php";?>
			<div class="main">
			  <div class='left-block'>
				<?php require "components/page_03/table.php"?>
			  </div>
			  <div class='right-block'>
			    <?php require "components/page_03/form.htm"?>
			  </div>
			</div>
		</div>
	</body>
</html>