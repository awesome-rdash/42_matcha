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
$page = 0;

if (isset($_SESSION['gallery_parameters']['order'])) {
	$order = $_SESSION['gallery_parameters']['order'];
}

if (isset($_SESSION['gallery_parameters']['ppp'])) {
	$ppp = $_SESSION['gallery_parameters']['ppp'];
}

if (isset($_SESSION['gallery_parameters']['uid'])) {
	$uid = $_SESSION['gallery_parameters']['uid'];
}

if (isset($_POST["order"])) {
	if ($_POST["order"] === "asc") {
		$_SESSION['gallery_parameters']['order'] = "ASC";
		$order = $_SESSION['gallery_parameters']['order'];
	} else if ($_POST["order"] === "desc"){
		$_SESSION['gallery_parameters']['order'] = "DESC";
		$order = $_SESSION['gallery_parameters']['order'];
	}
}

if (isset($_POST['ppp'])) {
	if ($_POST['ppp'] == 10 || $_POST['ppp'] == 25 || $_POST['ppp'] == 50 || $_POST['ppp'] == 100) {
		$_SESSION['gallery_parameters']['ppp'] = intval($_POST['ppp']);
		$ppp = $_SESSION['gallery_parameters']['ppp'];
	}
}

if (isset($_POST['uid'])) {
	if ($mm->ifExist("id", intval($_POST['uid']) || $_POST['uid'] == 0)) {
		$_SESSION['gallery_parameters']['uid'] = intval($_POST['uid']);
		$uid = $_SESSION['gallery_parameters']['uid'];
	}
}

$count = $picManager->getEditedPicturesCount($uid, $ppp);
$nbPages = intval($count[0] / $ppp);	

if (isset($_GET['page'])) {
	if (is_numeric($_GET['page'])) {
		if ($_GET['page'] > 0 && $_GET['page'] <= $nbPages) {
			$startAt = intval($_GET['page']) * $ppp;
			$page = $_GET['page'];
		}
	}
}

$pics = $picManager->getEditedPictures($uid, $ppp, $order, $startAt);

$usersList = $mm->getAllExistingUsers();