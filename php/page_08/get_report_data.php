<?php
	function get_report_data() {
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

		return $data;
	}
?>