<?php

/* 
 * Connection to database 
 */
if (file_exists("config/cfg.ini")) {
	$bdd_infos = parse_ini_file("config/cfg.ini");
	if (!isset($bdd_infos['db_name']) ||
		!isset($bdd_infos['db_host']) ||
		!isset($bdd_infos['db_username']) ||
		!isset($bdd_infos['db_passwd']) ||
		!isset($bdd_infos['db_port'])) {
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