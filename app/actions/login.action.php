<?php
$toCheck = array("nickname", "password");

foreach($toCheck as $element) {
	if (!isset($_POST[$element]) || empty($_POST[$element])) {
		$error = genError("login", "missingfield", $element);
	}
}

if (!isset($error)) {
	$manager = new MemberManager($db);
	$return = $manager->getFromNickname(htmlspecialchars($_POST['nickname']));
	if (is_object($return)) {
		if ($manager->isPasswordCorrect($return->getId(), htmlspecialchars($_POST['password']))) {
			$_SESSION['connected'] = true;
			$_SESSION['userid'] = $return->getId();
			$redirection = true;
		} else {
			$error = genError("login", "invalid", "password");
		}
	} else {
		$error = genError("login", "notfound", "nickname");
	}
}