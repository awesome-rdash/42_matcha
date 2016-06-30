<?php

if (!isset($_GET['token']) || empty($_GET['token'])) {
	$error = genError('token', 'missing', 'usetoken');
}

if (!isset($error)) {
	$token_manager = new TokenManager($db);
	$token = $token_manager->getFromToken(htmlspecialchars($_GET['token']));
	if (!is_object($token)) {
		$error = genError('token', 'invalid', 'usetoken');
	}
}

if (!isset($error)) {
	if ($token->isUsed()) {
		$error = genError('token', 'alreadyused', 'usetoken');
	}
	if ($token->getTime_created() < (time() - (60 * 60))) {
		$error = genError('token', 'outdated', 'usetoken');
	}
}

if (!isset($error)) {
	$manager = new MemberManager($db);
	$member = $manager->getFromId($token->getUser_id());
	if (!is_object($member)) {
		$error = genError('token', 'unknownuser', 'usetoken');
	}
}

if (!isset($error)) {
	$usage = $token->getUsefor();
	switch ($usage) {
		case "mailconfirmation":
			$member->setMail_confirmed(true);
			$manager->update($member);
		break;
	}
}

if (!isset($error)) {
	$token->setIsused(true);
	$token_manager->update($token);
}