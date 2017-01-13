<?php

include_once("app/init.app.php");

$pageTitle = "Profil";
$pageStylesheets = array ("main.css", "header.css");

if (isUserLogged()) {
	if (isset($_GET['member']) && !empty($_GET['member'])) {
		$memberManager = new MemberManager($db);
		$currentProfil = $memberManager->get("id", int($_GET['member']));
		if ($currentProfil === false) {
			header ("location: profile.php");
		}

	} else {
		$currentProfil = $currentUser;
	}
}