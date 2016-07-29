<?php

include_once("app/init.app.php");

$pageTitle = "Galerie";
$pageStylesheets = array ("main.css", "header.css", "gallery.css");

$picManager = new UserPictureManager($db);
$pics = $picManager->getEditedPictures();