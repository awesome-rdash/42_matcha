<?php

if (!isset($action['token']) || empty($action['token'])) {
	$error = genError('token', 'missing', 'usetoken');
}

if (!isset($error)) {
	$token_manager = new TokenManager($db);
	$token = $token_manager->getFromToken(htmlspecialchars($action['token']));
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
			$tokenUsed = true;
			break;
		case "resetpassword":
			if (isset($_POST['newpassword']) && !empty($_POST['newpassword'])) {
				if ($member->setPassword($_POST['newpassword'])) {
					$member->setPassword(hash("whirlpool", $_POST['newpassword']));
					$manager->update($member);
					$tokenUsed = true;
				} else {
					$custom_module = "reset_password";
				}
			} else {
				$custom_module = "reset_password";
			}
			break;
	}
}

if (!isset($error) && isset($tokenUsed)) {
	$token->setIsused(true);
	$token_manager->update($token);
}