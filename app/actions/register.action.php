<?php

$toCheck = array("nickname", "email", "password", "password2", "firstname", "lastname", "bday");

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
	if ($_POST['password'] !== $_POST['password2']) {
		$error = genError("member", "notthesame", "password");
	} else {
		$member = new Member(0);
		$member->setPassword($_POST['password'], true);
	}
}

if (!isset($error)) {
	$parameters = array(
		"nickname" => $_POST['nickname'], 
		"email" => $_POST['email'],
		"firstname" => $_POST['firstname'],
		"lastname" => $_POST['lastname'],
		"bdayFromString" =? $_POST['bday']);
	$return = $member->hydrate($parameters);
	if ($return !== true) {
		$error = $return;
	} else {
		$member->setRegister_time(time());
		$addedId = $manager->add($member);
		$member->setId($addedId);
	}
}

if (!isset($error)) {
	$confirmationToken = new Token(0);
	$parameters = array(
		"user_id" => $member->getId(),
		"usefor" => "mailconfirmation");
	$confirmationToken->hydrate($parameters);
	$manager = new TokenManager($db);

	$manager->add($confirmationToken);

	$message = "Lien : " . Utilities::getAddress() . "index.php?action=useToken&token=" . $confirmationToken->getToken();

	utilities::sendMail($member->getEmail(), "Confirmation d'inscription", $message);
}

if (isset($error)) {
	$error['module'] = "register";
}