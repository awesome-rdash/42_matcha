<?php
$pageTitle = "Camagru";
$pageStylesheets = array ("main.css", "header.css");
if ($user['connected'] === true) {
	$pageStylesheets[] = "index/logged.index.css";
} else {
	$pageStylesheets[] = "index/unlogged.index.css";
}

include_once("app/init.app.php");