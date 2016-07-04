<?php

include_once("app/init.app.php");

$pageTitle = "Camagru";
$pageStylesheets = array ("main.css", "header.css");
if (isUserLogged()) {
	$pageStylesheets[] = "camera/logged.camera.css";
} else {
	$pageStylesheets[] = "camera/unlogged.camera.css";
}