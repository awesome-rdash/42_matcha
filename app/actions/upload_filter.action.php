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
	$type = @getimagesize($_FILES['filter_file']['tmp_name']);
	if (is_array($type)) {
		if ($type['mime'] != "image/png") {
			$error = genError("upload_filter", "invalid_file", "file");
		}
	} else {
		$error = genError("upload_filter", "invalid_file", "file");
	}
}

if (!isset($error)) {
	$filter = new Filter(0);
	$parameters = array(
		"owner_id" => $currentUser->getId());
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

if (isset($error)) {
	echo "error";
}