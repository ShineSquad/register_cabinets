
<header>
	<a class="link" href="./page_04_corpuses.php">Корпуса</a>
	<a class="link" href="./page_02_cabinets.php">Кабинеты</a>
	<a class="link" href="./page_01_software.php">Программное обеспечение</a>
	<a class="link" href="./page_05_workplaces.php">Компьютерные рабочие места</a>
	<a class="link" href="./page_06_wp_in_cabinet.php">Рабочие места в кабинете</a>
	<a class="link" href="./page_03_discipline.php">Предметы</a>
	<a class="link" href="./page_07_cab_to_discipline.php">Кабинеты к предмету</a>
	<a class="link" href="./page_08_report.php">Отчёты</a>
	<script type="text/javascript">
		var h = document.getElementsByTagName("header")[0],
			n = <?php echo $p;?>;
		h.children[n].className += " active-link";
	</script>
</header>