<?php

/* 
 * Connection to database 
 */
if (file_exists("config/cfg.ini")) {
	$db_infos = parse_ini_file("config/cfg.ini");
	if (!isset($db_infos['db_name']) ||
		!isset($db_infos['db_host']) ||
		!isset($db_infos['db_username']) ||
		!isset($db_infos['db_passwd']) ||
		!isset($db_infos['db_port'])) {
		header("Location: error.php");
	}
} else {
	header("Location: config/setup.php");
}

include ("config/database.php");

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
} catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}

require_once("app/class/Member.class.php");
require_once("app/class/MemberManager.php");

session_start();

require_once("app/action.app.php");