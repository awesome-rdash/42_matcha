<?php

include_once("app/init.app.php");

if ($_SESSION['connected'] == false)
	header("location: index.php");

$pageTitle = "Parcours Matcha";
$pageStylesheets = array ("main.css", "header.css", "index.css");

$ageMin = $currentUser->getAge() - 10;
$ageMax = $currentUser->getAge() + 10;
$popMin = 10;
$popMax = 0;
$localisation = $currentUser->getLocationInString();
$tags = "";
$tagsList = "";
$locMax = 15;
$sortMethod = "popularity";
$sortOrder = "asc";
$localisationLatLong = array("lat" => $currentUser->getLocationLat(), "long" => $currentUser->getLocationLong());

if ($currentUser->getSexual_orientation() == "male") {
	$sexe = 0;
} else if ($currentUser->getSexual_orientation() == "female") {
	$sexe = 1;
} else {
	$sexe = "both";
}

if ($currentUser->getSexe() == 0) {
	$sexuality = "male";
} else if ($currentUser->getSexe() == 1) {
	$sexuality = "female";
} else {
	$sexuality = "both";
}

$mm = new MemberManager($db);
$tm = new TagManager($db);

if (isset($_SESSION['parcours_parameters']['sortOrder']))
	$sortOrder = $_SESSION['parcours_parameters']['sortOrder'];

if (isset($_SESSION['parcours_parameters']['ageMin']))
	$ageMin = $_SESSION['parcours_parameters']['ageMin'];

if (isset($_SESSION['parcours_parameters']['ageMax']))
	$ageMax = $_SESSION['parcours_parameters']['ageMax'];

if (isset($_SESSION['parcours_parameters']['popMin']))
	$popMin = $_SESSION['parcours_parameters']['popMin'];

if (isset($_SESSION['parcours_parameters']['popMax']))
	$popMax = $_SESSION['parcours_parameters']['popMax'];

if (isset($_SESSION['parcours_parameters']['locMax']))
	$locMax = $_SESSION['parcours_parameters']['locMax'];

if (isset($_SESSION['parcours_parameters']['sortMethod'])) {
	$sortMethod = $_SESSION['parcours_parameters']['sortMethod'];
}

if (isset($_POST['ageMin'])) {
	if ($_POST['ageMin'] > 0 && ($_POST['ageMin'] <= $_POST['ageMax'] || $_POST['ageMax'] == 0))
		$ageMin = intval($_POST['ageMin']);
	else
		$ageMin = 0;
	$_SESSION['parcours_parameters']['ageMin'] = $ageMin;
}

if (isset($_POST['ageMax'])) {
	if ($_POST['ageMax'] > 0 && ($_POST['ageMax'] >= $ageMin || $ageMin == 0))
		$ageMax = intval($_POST['ageMax']);
	else
		$ageMax = 0;
	$_SESSION['parcours_parameters']['ageMax'] = $ageMax;
}

if (isset($_POST['popMin'])) {
	if ($_POST['popMin'] > 0 && ($_POST['popMin'] <= $_POST['popMax'] || $_POST['popMax'] == 0))
		$popMin = intval($_POST['popMin']);
	else
		$popMin = 0;
	$_SESSION['parcours_parameters']['popMin'] = $popMin;
}

if (isset($_POST['popMax'])) {
	if ($_POST['popMax'] > 0 && ($_POST['popMax'] >= $popMin || $popMin == 0))
		$popMax = intval($_POST['popMax']);
	else
		$popMax = 0;
	$_SESSION['parcours_parameters']['popMax'] = $popMax;
}

if (isset($_POST['locMax'])) {
	if ($_POST['locMax'] >= 0) {
		$locMax = intval($_POST['locMax']);
		$_SESSION['parcours_parameters']['locMax'] = $locMax;
	}
}

if (isset($_POST['tags']) && !empty($_POST['tags'])) {
	$tagsToCheck = explode(",", $_POST['tags']);
	$tagsList = array();

	foreach($tagsToCheck as $tagData) {
		$tagData = trim($tagData);
		if (!in_array($tagData, $tagsList) && $tm->ifExist($tagData)) {
			$tags .= ($tags == "") ? $tagData : (", " . $tagData);
			$tagsList[] = $tagData;
		}
	}
} else {
	$tagsFromUser = $tm->getAllTagsFromMemberId($currentUser->getId());
	$tagsList = array();

	foreach($tagsFromUser as $tagData) {
		$tag = $tm->getTagContentFromId($tagData->getId());
		$tags .= ($tags == "") ? $tag : (", " . $tag);
		$tagsList[] = $tag;
	}
}

if (isset($_POST['sortMethod'])) {
	switch($_POST['sortMethod']) {
		case "age":
			$sortMethod = "age";
			$_SESSION['parcours_parameters']['sortMethod'] = $sortMethod;
			break;

		case "popularity":
			$sortMethod = "popularity";
			$_SESSION['parcours_parameters']['sortMethod'] = $sortMethod;
			break;

		case "localisation":
			$sortMethod = "localisation";
			$_SESSION['parcours_parameters']['sortMethod'] = $sortMethod;
			break;

		case "tags":
			$sortMethod = "tags";
			$_SESSION['parcours_parameters']['sortMethod'] = $sortMethod;
			break;
		break;
	}
}

if (isset($_POST["sortOrder"])) {
	if ($_POST["sortOrder"] === "asc") {
		$_SESSION['parcours_parameters']['sortOrder'] = "asc";
		$sortOrder = $_SESSION['parcours_parameters']['sortOrder'];
	} else if ($_POST["sortOrder"] === "desc"){
		$_SESSION['parcours_parameters']['sortOrder'] = "desc";
		$sortOrder = $_SESSION['parcours_parameters']['sortOrder'];
	}
}

$users = Utilities::search_users($ageMin, $ageMax, $popMin, $popMax, $locMax, $localisationLatLong, $tagsList, $sexe, $sexuality, $sortMethod, $sortOrder, $currentUser->getId());