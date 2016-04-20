<?php

/* 
 * Connection to database 
 */
if (file_exists("config/cfg.ini")) {
	$ini = parse_ini_file("config/cfg.ini");
	if (!isset($ini['db_name']) ||
		!isset($ini['server_adress']) ||
		!isset($ini['db_user']) ||
		!isset($ini['db_password'])) {
		header("Location: error.php");
	}
} else {
	header("Location: error.php");
}

include ("config/database.php");
try {
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
} catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}