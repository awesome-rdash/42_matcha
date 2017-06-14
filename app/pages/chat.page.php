<?php

include_once("app/init.app.php");

$pageTitle = "Chat";
$pageStylesheets = array ("main.css", "header.css");

/*
- Si chat avec personne, liste ecrite des pseudos avec qui il peut chat
- si chat avec une personne
-- si lid nexiste pas, redirection vers page sans chat

*/

if (isUserLogged()) {
	$ownProfile = false;
	if (isset($_GET['member']) && !empty($_GET['member']) && (int)$_GET['member'] != $currentUser->getId()) {
		$memberManager = new MemberManager($db);
		$currentProfile = $memberManager->get("id", (int)$_GET['member']);
		if ($currentProfile == false) {
			header ("location: chat.php");
		}
		$profileLikeManager = new ProfileLikeManager($db);
		if (!$profileLikeManager->isThereAMutualLike($currentProfile->getId(), $currentUser->getId())) {
			header ("location: chat.php");
		}
	} else {
		$ownProfile = true;
	}
} else {
	header ("location: index.php");
}