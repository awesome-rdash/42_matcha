<?php

$toCheck = array("id");

foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("delete_picture", "missingparam", $element);
	}
}

if (!isset($error)) {
	$pictureManager = new UserPictureManager($db);
	$pic = $pictureManager->get($action['id']);
	if (is_object($pic)) {
		if ($pic->getOwner_id() === $currentUser->getId()) {
			$pictureManager->delete($pic->getId());
		}
	}
}

header("Location: gallery.php");