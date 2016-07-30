<?php

include_once("app/init.app.php");

$pageTitle = "Camagru";
$pageStylesheets = array ("main.css", "header.css", "camera.css");

$filterManager = new FilterManager($db);
$filters = $filterManager->getList();

if (isUserLogged()) {
	$upm = new UserPictureManager($db);
	$lastPictures = $upm->getEditedPicturesFromUser($currentUser->getId());
}