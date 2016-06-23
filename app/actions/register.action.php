<?php

$toCheck = array("nickname", "email", "password", "password2", "birthdate");

foreach($_POST as $key => $value) {
	if (empty($_POST[$key])) {
		unset($_POST[$key]);
	}
}

foreach($toCheck as $element) {
	if (!isset($_POST[$element])) {
		$error = genError("register", "missingfield", $element);
	}
}

if (!isset($error)) {
	$toCheck = array("nickname", "email");
	$manager = new MemberManager($db);
	foreach($toCheck as $element) {
		if ($manager->ifExist($element, $_POST[$element])) {
			$error = genError("member", "alreadyexist", $element);
			break;
		}
	}
}

if (!isset($error)) {
	$member = new Member(0);
	$return = $member->hydrate($_POST);
	if ($return !== true) {
		$error = $return;
	}
}

if (!isset($error)) {
	if ($member->isPasswordConfirmationCorrect()) {
		$addedId = $manager->add($member);
		$member->setId($addedId);
	}
	else {
		$error = genError("member", "notthesame", "password");
	}
}

if (!isset($error)) {
	$confirmationToken = new Token(0);
	$parameters = array(
		"userId" => $member->getId(),
		"usefor" => "mailconfirmation");
	$confirmationToken->hydrate($parameters);
	$manager = new TokenManager($db);

	$manager->add($confirmationToken);
}

if (isset($error)) {
	$error['module'] = "register";
}