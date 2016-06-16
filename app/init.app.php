<?php

/* 
 * Connection to database 
 */
if (file_exists("config/cfg.ini")) {
	$bdd_infos = parse_ini_file("config/cfg.ini");
	if (!isset($bdd_infos['db_name']) ||
		!isset($bdd_infos['server_adress']) ||
		!isset($bdd_infos['db_user']) ||
		!isset($bdd_infos['db_password'])) {
		header("Location: error.php");
	}
} else {
	header("Location: config/setup.php");
}

include ("config/database.php");
try {
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
} catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}

session_start();