<?php
$toCheck = array("image");

foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("upload_camera_image", "missingparam", $element);
	}
}

$image = new UserPicture(0);
$parameters = array(
	"owner_id" => $currentUser->getId(),
	"upload_source" => "camera",
	"filter_used" => "1");
$image->hydrate($parameters);

$imageManager = new UserPictureManager($db);
$imageManager->add($image);