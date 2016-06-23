<?php
echo "no redirection <br />";

if (!isset($_GET['token']) || empty($_GET['token'])) {
	$error = genError('token', 'missing', 'token');
}

if (!isset($error)) {
	$manager = new TokenManager($db);
	$token = $manager->getFromToken(htmlspecialchars($_GET['token']));
	if (!is_object($token)) {
		$error = genError('token', 'invalid', 'token');
	}
}

if (!isset($error)) {
	if ($token->isUsed()) {
		$error = genError('token', 'alreadyused', 'token');
	}
	if ($token->getTime_created() < (time() - (60 * 60))) {
		$error = genError('token', 'outdated', 'token');
	}
}

if (!isset($error)) {
	$manager = new MemberManager($db);
	$member = $manager->getFromId($token->getId());
}

switch ($token->getUsefor()) {
	case "mailconfirmation":
		break;
}