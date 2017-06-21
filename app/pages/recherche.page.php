<?php

include_once("app/init.app.php");

$pageTitle = "Recherche Matcha";
$pageStylesheets = array ("main.css", "header.css", "index.css");

$ageMin = 0;
$ageMax = 0;
$popMin = 0;
$popMax = 0;
$localisation = 0;
$tags = "";
$locMax = 0;
$sexe = "both";
$sexuality = "both";
$sortMethod = "popularity";
$sortOrder = "asc";

$mm = new MemberManager($db);
$tm = new TagManager($db);

if (isset($_SESSION['recherche_parameters']['sortOrder']))
	$sortOrder = $_SESSION['recherche_parameters']['sortOrder'];

if (isset($_SESSION['recherche_parameters']['ageMin']))
	$ageMin = $_SESSION['recherche_parameters']['ageMin'];

if (isset($_SESSION['recherche_parameters']['ageMax']))
	$ageMax = $_SESSION['recherche_parameters']['ageMax'];

if (isset($_SESSION['recherche_parameters']['popMin']))
	$popMin = $_SESSION['recherche_parameters']['popMin'];

if (isset($_SESSION['recherche_parameters']['popMax']))
	$popMax = $_SESSION['recherche_parameters']['popMax'];

if (isset($_SESSION['recherche_parameters']['locMax']))
	$locMax = $_SESSION['recherche_parameters']['locMax'];

if (isset($_SESSION['recherche_parameters']['sexuality']))
	$sexe = $_SESSION['recherche_parameters']['sexuality'];

if (isset($_SESSION['recherche_parameters']['sexe']))
	$sexe = $_SESSION['recherche_parameters']['sexe'];

if (isset($_SESSION['recherche_parameters']['sortMethod'])) {
	$sortMethod = $_SESSION['recherche_parameters']['sortMethod'];
}

if (isset($_POST['ageMin'])) {
	if ($_POST['ageMin'] > 0 && ($_POST['ageMin'] <= $_POST['ageMax'] || $_POST['ageMax'] == 0))
		$ageMin = intval($_POST['ageMin']);
	else
		$ageMin = 0;
	$_SESSION['recherche_parameters']['ageMin'] = $ageMin;
}

if (isset($_POST['ageMax'])) {
	if ($_POST['ageMax'] > 0 && ($_POST['ageMax'] >= $ageMin || $ageMin == 0))
		$ageMax = intval($_POST['ageMax']);
	$_SESSION['recherche_parameters']['ageMax'] = $ageMax;
}

if (isset($_POST['popMin'])) {
	if ($_POST['popMin'] > 0 && ($_POST['popMin'] <= $_POST['popMax'] || $_POST['popMax'] == 0))
		$popMin = intval($_POST['popMin']);
	else
		$popMin = 0;
	$_SESSION['recherche_parameters']['popMin'] = $popMin;
}

if (isset($_POST['popMax'])) {
	if ($_POST['popMax'] > 0 && ($_POST['popMax'] >= $popMin || $popMin == 0))
		$popMax = intval($_POST['popMax']);
	$_SESSION['recherche_parameters']['popMax'] = $popMax;
}

if (isset($_POST['locMax'])) {
	if ($_POST['locMax'] > 0) {
		$locMax = intval($_POST['locMax']);
		$_SESSION['recherche_parameters']['locMax'] = $locMax;
	}
}

if (isset($_POST['tags'])) {
	$tagsToCheck = explode(",", $_POST['tags']);
	$tagsList = array();

	foreach($tagsToCheck as $tagData) {
		$tagData = trim($tagData);
		if (!in_array($tagData, $tagsList) && $tm->ifExist($tagData)) {
			$tags .= ($tags == "") ? $tagData : (", " . $tagData);
			$tagsList[] = $tagData;
		}
	}
}

if (isset($_POST['sexe'])) {
	switch($_POST['sexe']) {
		case "male":
			$sexe = "male";
			$_SESSION['recherche_parameters']['sexe'] = $sexe;
			break;

		case "female":
			$sexe = "female";
			$_SESSION['recherche_parameters']['sexe'] = $sexe;
			break;

		case "both":
			$sexe = "both";
			$_SESSION['recherche_parameters']['sexe'] = $sexe;
			break;
		break;
	}
}

if (isset($_POST['sexuality'])) {
	switch($_POST['sexuality']) {
		case "male":
			$sexuality = "male";
			$_SESSION['recherche_parameters']['sexuality'] = $sexuality;
			break;

		case "female":
			$sexuality = "female";
			$_SESSION['recherche_parameters']['sexuality'] = $sexuality;
			break;

		case "both":
			$sexuality = "both";
			$_SESSION['recherche_parameters']['sexuality'] = $sexuality;
			break;
		break;
	}
}

if (isset($_POST['sortMethod'])) {
	switch($_POST['sortMethod']) {
		case "age":
			$sortMethod = "age";
			$_SESSION['recherche_parameters']['sortMethod'] = $sortMethod;
			break;

		case "popularity":
			$sortMethod = "popularity";
			$_SESSION['recherche_parameters']['sortMethod'] = $sortMethod;
			break;

		case "localisation":
			$sortMethod = "localisation";
			$_SESSION['recherche_parameters']['sortMethod'] = $sortMethod;
			break;

		case "tags":
			$sortMethod = "tags";
			$_SESSION['recherche_parameters']['sortMethod'] = $sortMethod;
			break;
		break;
	}
}

if (isset($_POST["sortOrder"])) {
	if ($_POST["sortOrder"] === "asc") {
		$_SESSION['recherche_parameters']['sortOrder'] = "asc";
		$sortOrder = $_SESSION['recherche_parameters']['sortOrder'];
	} else if ($_POST["sortOrder"] === "desc"){
		$_SESSION['recherche_parameters']['sortOrder'] = "desc";
		$sortOrder = $_SESSION['recherche_parameters']['sortOrder'];
	}
}

// Fonction de recherche
function search_users($ageMin, $ageMax, $popMin, $popMax, $locMax, $tags, $sexe, $sortMethod, $sortOrder) {
	global $db;
	$mm = new MemberManager($db);
	$tm = new TagManager($db);
	$totalUsers = $mm->getAllExistingUsers();

	$finalListOfUsers = array();

	foreach ($totalUsers as $user) {
		$member = new Member(0);
		$member->hydrate($user);

		if (
			($ageMin == 0 || $member->getAge() >= $ageMin) &&
			($ageMax == 0 || $member->getAge() <= $ageMax) &&
			($popMin == 0 || $member->getPopularity() >= $popMin) &&
			($popMax == 0 || $member->getPopularity() <= $popMax) &&
			($sexe == 0 || $member->getSexe() == $sexe) &&
			($sexuality == 0 || $member->getSexuality() == $sexuality)
		) {
			$finalListOfUsers[] = $member;
		}
	}

	return ($finalListOfUsers);
}

$users = search_users($ageMin, $ageMax, $popMin, $popMax, $locMax, $tags, $sexe, $sortMethod, $sortOrder);