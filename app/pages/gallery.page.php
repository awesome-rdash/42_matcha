<?php

include_once("app/init.app.php");

$pageTitle = "Galerie";
$pageStylesheets = array ("main.css", "header.css", "gallery.css");

$mm = new MemberManager($db);
$picManager = new UserPictureManager($db);

$uid = 0;
$ppp = 25;
$order = "DESC";
$startAt = 0;

if (isset($_POST["order"])) {
	if ($_POST["order"] === "asc") {
		$order = "ASC";
	}
}

if (isset($_POST['ppp'])) {
	if ($_POST['ppp'] == 10 || $_POST['ppp'] == 25 || $_POST['ppp'] == 50 || $_POST['ppp'] == 100) {
		$ppp = intval($_POST['ppp']);
	}
}

if (isset($_POST['uid'])) {
	if ($mm->ifExist("id", intval($_POST['uid']))) {
		$uid = intval($_POST['uid']);
	}
}

$count = $picManager->getEditedPicturesCount($uid, $ppp);
$nbPages = $count[0] / $ppp;

if (isset($_GET['page'])) {
	if (is_numeric($_GET['page'])) {
		if ($_GET['page'] > 0 && $_GET['page'] <= $nbPages) {
			$startAt = intval($_GET['page']) * $ppp;
		}
	}
}

$pics = $picManager->getEditedPictures($uid, $ppp, $order, $startAt);

$usersList = $mm->getAllExistingUsers();