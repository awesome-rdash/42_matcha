<?php

include_once("app/init.app.php");

$pageTitle = "Image";
$pageStylesheets = array ("main.css", "header.css", "picture.css");

if (isset($_GET['pic']) && !empty($_GET['pic'])) {
	$picManager = new UserPictureManager($db);
	$pic = $picManager->get($_GET['pic']);
	if ($pic === false) {
		header ("location: gallery.php");
	}

	$commentManager = new CommentManager($db);
	$comments = $commentManager->getFromPicture($pic->getId());

	$likeManager = new LikeManager($db);
} else {
	header ("location: gallery.php");
}