<?php

include_once("app/init.app.php");

$pageTitle = "Profil";
$pageStylesheets = array ("main.css", "header.css");

if (isUserLogged()) {
	$ownProfile = false;
	if (isset($_GET['member']) && !empty($_GET['member'])) {
		$memberManager = new MemberManager($db);
		$currentProfile = $memberManager->get("id", (int)$_GET['member']);
		if ($currentProfile === false) {
			header ("location: profile.php");
		}

	} else {
		$ownProfile = true;
		$currentProfile = $currentUser;
	}
}

//Fonction qui permette d'afficher du texte ave l'icone de modification
function showEditableInfo($id, $text, $editForm) {
	$toShow = "<div id=\"" . $id . "\">" .
			  "<div id=\"" . $id . "_text\">" .
			  $text .
			  " <a onclick=\"change_visibility('" . $id . "_edit', '" . $id . "_text')\" href=\"#\"><img width=\"11px\" src=\"assets/img/icons/edit.svg\"</img></a>" .
			  "</div>" .
			  "<div id=\"" . $id . "_edit\">" .
			  $editForm .
			  "</div>";

	echo $toShow;
}