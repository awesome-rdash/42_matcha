<?php
$toCheck = array("data", "filter");

foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("upload_camera_image", "missingparam", $element);
	}
}

if (!isset($error)) {
	try {
		$data = base64_decode(substr($action['data'], 22));
		$source = imagecreatefromstring($data);
	} catch (Exception $e) {
		unset($e);
		$error = genError("upload_camera_image", "invalid", "image");
	}
}

if (!isset($error)) {
	$image = new UserPicture(0);
	$parameters = array(
		"owner_id" => $currentUser->getId(),
		"upload_source" => "camera",
		"filter_used" => 0,
		"source" => $source);
	$return = $image->hydrate($parameters);
	if ($return !== true) {
		$error = $return;
	}
}

if (!isset($error)) {
	$imageManager = new UserPictureManager($db);
	$image->setId($imageManager->add($image));
}

if (!isset($error)) {
	if ($image->addFilter($action['filter'])) {
		$image->setUpload_source("stock");
		$image->setFilter_used($action['filter']);
		$image->setId($imageManager->add($image));
		echo $image->getId();
	}
}

if (isset($error)) {
	echo "error";
}