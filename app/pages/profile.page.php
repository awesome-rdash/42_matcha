<?php

include_once("app/init.app.php");

$pageTitle = "Profil";
$pageStylesheets = array ("main.css", "header.css", "profile.css", "awesomplete.css");

if (isUserLogged()) {
	$ownProfile = false;
	if (isset($_GET['member']) && !empty($_GET['member']) && (int)$_GET['member'] != $currentUser->getId()) {
		$memberManager = new MemberManager($db);
		$currentProfile = $memberManager->get("id", (int)$_GET['member']);
		if ($currentProfile === false) {
			header ("location: profile.php");
		}
		$profileVisitManager = new ProfileVisitManager($db);
		$profileVisitManager->addVisit($currentUser->getId(), $currentProfile->getId());
	} else {
		$ownProfile = true;
		$currentProfile = $currentUser;
	}
}

function showEditableInfo($id, $text, $editForm) {
	$toShow = "<div id=\"" . $id . "_block\">" .
			  "<div id=\"" . $id . "_text\">" .
			  $text .
			  " <a onclick=\"change_visibility('" . $id . "')\" href=\"#\"><img width=\"11px\" src=\"assets/img/icons/edit.svg\"</img></a>" .
			  "</div>" .
			  "<div id=\"" . $id . "_edit\" style=\"display: None;\" >" .
			  $editForm .
			  "<input type=\"button\" value=\"Modifier\" onclick=\"update" . ucfirst($id) . "()\" />
			  <input type=\"button\" value=\"Annuler\" onclick=\"change_visibility('" . $id . "')\" /></div>
			  </div>";

	echo $toShow;
}

$tagManager = new TagManager($db);