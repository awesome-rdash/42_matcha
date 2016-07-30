<?php

if (!isset($error)) {
	if (!isset($_FILES['filter_file']) || empty($_FILES['filter_file'])) {
		$error = genError("upload_filter", "missingfile", "file");
	}
}

if (!isset($error)) {
	$allowedTypes = array("image/png");
	if (!in_array($_FILES['filter_file']['type'], $allowedTypes)) {
		$error = genError("upload_filter", "invalid_extension", "file");
	}
}

if (!isset($error)) {
	$type = exif_imagetype($_FILES['filter_file']['tmp_name']);
	if ($type !== IMAGETYPE_PNG) {
		$error = genError("upload_filter", "invalid_file", "file");
	}
}

if (!isset($error)) {
	$source = imagecreatefrompng($_FILES['filter_file']['tmp_name']);

	$filter = new Filter(0);
	$parameters = array(
		"owner_id" => $currentUser->getId(),
		"source" => $source);
	$return = $filter->hydrate($parameters);
	if ($return !== true) {
		$error = $return;
	}
}

if (!isset($error)) {
	$fm = new FilterManager($db);
	$filter->setId($fm->add($filter));
	move_uploaded_file($_FILES["filter_file"]["tmp_name"], "data/userfilters/" . $filter->getId() . ".png");
	echo $filter->getId();
}