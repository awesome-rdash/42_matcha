<?php

$toCheck = array("nickname", "email", "password", "password2", "birthdate");

foreach($toCheck as $element) {
	if (!isset($_POST[$element]) || empty($_POST[$element])) {
		$error = genError("register", "missingfield", $_POST);
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
}

if (!isset($error)) {
	if (is_object($return)) {
		$member = $return;
	} else {
		$error = $return;
	}
}

if (!isset($error)) {
	if ($member->isPasswordConfirmationCorrect()) {
		$manager->add($member);
	}
	else {
		$error = genError("member", "notthesame", "password");
	}
}