<?php

$toCheck = array("filter");
foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("upload_camera_image", "missingparam", $element);
	}
}

if (!isset($error)) {
	if (!isset($_FILES['image_file']) || empty($_FILES['image_file'])) {
		$error = genError("upload_camera_image", "missingfile", "file");
	}
}

if (!isset($error)) {
	$allowedTypes = array("image/jpeg", "image/jpg", "image/png");
	if (!in_array($_FILES['image_file']['type'], $allowedTypes)) {
		$error = genError("upload_camera_image", "invalid_extension", "file");
	}
}

if (!isset($error)) {
	$type = @getimagesize($_FILES['image_file']['tmp_name']);
	if (is_array($type)) {
		if ($type['mime'] != "image/png" && $type['mime'] != "image/jpeg") {
			$error = genError("upload_camera_image", "invalid_file", "file");
		}
	} else {
		$error = genError("upload_camera_image", "invalid_file", "file");
	}
}

if (!isset($error)) {
	if ($type['mime'] == "image/jpeg") {
		$source = imagecreatefromjpeg($_FILES['image_file']['tmp_name']);
	} else if ($type['mime'] == "image/png") {
		$source = imagecreatefrompng($_FILES['image_file']['tmp_name']);
	}

	$image = new UserPicture(0);
	$parameters = array(
		"owner_id" => $currentUser->getId(),
		"upload_source" => "file",
		"filter_used" => 0,
		"source" => $source);
	$return = $image->hydrate($parameters);
	if ($return !== true) {
		$error = $return;
	}
}

if (!isset($error)) {
	if ($image->addFilter($action['filter'])) {
		$imageManager = new UserPictureManager($db);
		$image->setUpload_source("stock");
		$image->setFilter_used($action['filter']);
		$image->setId($imageManager->add($image));
		echo $image->getId();
	}
}
if (isset($error)) {
	echo "error";
}