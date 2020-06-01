<?php
function JSONtoTABLE($db_link, $JSONstr) {
	$JSON = json_decode($JSONstr, true);
	$name = $JSON["name"];

	$sql = "CREATE TABLE IF NOT EXISTS $name (";
	foreach ($JSON["columns"] as $key => $value) {
		$sql .= "$key $value, ";
	}

	$sql .= 'PRIMARY KEY (' . $JSON["primary_key"] . ')';

	if (isset($JSON["foreign_keys"])) {
		foreach ($JSON["foreign_keys"] as $key => $value) {
			$sql .= ", FOREIGN KEY (" . $value["column"] . ") REFERENCES " . $value["ref"];
			if (isset($value["options"])) {
				$sql .= " " . $value["options"];
			}
		}
	}

	$sql .= ") DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	//echo $sql . '<br>';
	mysqli_query($db_link, $sql);
}

$tables = array();
$tables[] = '{
	"name": "discipline",
	"columns": {
		"id":   "INT AUTO_INCREMENT",
		"name": "TEXT NOT NULL"
	},
	"primary_key": "id"
}';

$tables[] = '{
	"name": "corpus",
	"columns": {
		"id":     "INT AUTO_INCREMENT",
		"name":   "TEXT NOT NULL",
		"liter":  "TEXT NOT NULL",
		"adress": "TEXT NOT NULL"
	},
	"primary_key": "id"
}';
$tables[] = '{
	"name": "cabinets",
	"columns": {
		"id":          "INT AUTO_INCREMENT",
		"name":        "TEXT NOT NULL",
		"number":      "INT NOT NULL",
		"corpus_id":   "INT NOT NULL",
		"type":        "TEXT NOT NULL",
		"sit_place":   "INT NOT NULL",
		"workplaces":  "INT NOT NULL",
		"lector_wp":   "BOOLEAN NOT NULL",
		"whiteboard":  "BOOLEAN NOT NULL",
		"proector":    "BOOLEAN NOT NULL",
		"interactive": "BOOLEAN NOT NULL"
	},
	"primary_key": "id",
	"foreign_keys": {
		"0": {
			"column": "corpus_id",
			"ref":    "corpus(id)",
			"options": "ON DELETE CASCADE"
		}
	}
}';
$tables[] = '{
	"name": "workplaces",
	"columns": {
		"id":   "INT AUTO_INCREMENT",
		"name": "TEXT NOT NULL"
	},
	"primary_key": "id"
}';
$tables[] = '{
	"name": "cabinet_workplaces",
	"columns": {
		"id":           "INT AUTO_INCREMENT",
		"cabinet_id":   "INT NOT NULL",
		"workplace_id": "INT NOT NULL",
		"invent_num":   "INT NOT NULL"
	},
	"primary_key": "id",
	"foreign_keys": {
		"0": {
			"column": "cabinet_id",
			"ref":    "cabinets(id)",
			"options": "ON DELETE CASCADE"
		},
		"1": {
			"column": "workplace_id",
			"ref":    "workplaces(id)",
			"options": "ON DELETE CASCADE"
		}
	}
}';
$tables[] = '{
	"name": "licenses",
	"columns": {
		"id":       "INT AUTO_INCREMENT",
		"name":     "TEXT NOT NULL",
		"doc_num":  "TEXT",
		"doc_file": "TEXT",
		"start_at": "DATE",
		"end_at":   "DATE"
	},
	"primary_key": "id"
}';
$tables[] = '{
	"name": "software",
	"columns": {
		"id":         "INT AUTO_INCREMENT",
		"name":       "TEXT NOT NULL",
		"version":    "TEXT",
		"type":       "TEXT",
		"license_id": "INT"
	},
	"primary_key": "id",
	"foreign_keys": {
		"0": {
			"column": "license_id",
			"ref":    "licenses(id)",
			"options": "ON DELETE CASCADE"
		}
	}
}';
$tables[] = '{
	"name": "workplace_software",
	"columns": {
		"id":         "INT AUTO_INCREMENT",
		"workplace_id": "INT NOT NULL",
		"software_id":  "INT NOT NULL"
	},
	"primary_key": "id",
	"foreign_keys": {
		"0": {
			"column": "workplace_id",
			"ref":    "workplaces(id)",
			"options": "ON DELETE CASCADE"
		},
		"1": {
			"column": "software_id",
			"ref":    "software(id)",
			"options": "ON DELETE CASCADE"
		}
	}
}';
$tables[] = '{
	"name": "report",
	"columns": {
		"id":            "INT AUTO_INCREMENT",
		"discipline_id": "INT NOT NULL",
		"cabinet_id":    "INT NOT NULL"
	},
	"primary_key": "id",
	"foreign_keys": {
		"0": {
			"column": "cabinet_id",
			"ref":    "cabinets(id)",
			"options": "ON DELETE CASCADE"
		},
		"1": {
			"column": "discipline_id",
			"ref":    "discipline(id)",
			"options": "ON DELETE CASCADE"
		}
	}
}';

// $tables[] = '{
// 	"name": "cabinet_software",
// 	"columns": {
// 		"id":           "INT AUTO_INCREMENT",
// 		"cabinet_id":   "INT NOT NULL",
// 		"software_id":  "INT NOT NULL"
// 	},
// 	"primary_key": "id",
// 	"foreign_keys": {
// 		"0": {
// 			"column": "cabinet_id",
// 			"ref":    "cabinets(id)",
// 			"options": "ON DELETE CASCADE"
// 		},
// 		"1": {
// 			"column": "software_id",
// 			"ref":    "software(id)",
// 			"options": "ON DELETE CASCADE"
// 		}
// 	}
// }';
require "db_link.php";

foreach ($tables as $key => $value) {
	JSONtoTABLE($link, $value);
}
?>