<?php

include_once("app/init.app.php");

$pageTitle = "Profil";
$pageStylesheets = array ("main.css", "header.css");

if (isUserLogged()) {
	$ownProfile = false;
	if (isset($_GET['member']) && !empty($_GET['member'])) {
		$memberManager = new MemberManager($db);
		$currentProfile = $memberManager->get("id", int($_GET['member']));
		if ($currentProfile === false) {
			header ("location: profile.php");
		}

	} else {
		$ownProfile = true;
		$currentProfile = $currentUser;
	}
}