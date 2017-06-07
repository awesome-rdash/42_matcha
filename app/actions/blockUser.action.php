<?php
$toCheck = array("id_user");

foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("blockUser", "missingfield", $element);
	}
}

if (!isset($error)) {
	if (isUserLogged()) {
		$userBlockManager = new UserBlockManager($db);
		$action['id_user'] = (int)$action['id_user'];
		if (!($userBlockManager->ifProfileIsAlreadyBlockedByUser($action['id_user'], $currentUser->getId()))) {
			$parameters = array(
				"fromUser" => $currentUser->getId(),
				"toUserBlocked" => $action['id_user']);
			$userBlock = new UserBlock(0);
			$state = $userBlock->hydrate($parameters);
			if ($state === true) {
				$userBlockManager->create($userBlock);
			} else {
				$error = $state;
			}
		}
	} else {
		$error = genError("blockUser", "notlogged", "login");
	}
}