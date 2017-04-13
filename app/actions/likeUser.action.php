<?php
$toCheck = array("id_user");

foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("like", "missingfield", $element);
	}
}

$notificationManager = new notificationManager($db);

if (!isset($error)) {
	if (isUserLogged() && $currentUser->getProfilePicture() != NULL) {
		$profileLikeManager = new ProfileLikeManager($db);
		$action['id_user'] = (int)$action['id_user'];
		if (!($profileLikeManager->ifProfileIsLikedByUser($action['id_user'], $currentUser->getId()))) {
			$parameters = array(
				"idUser" => $currentUser->getId(),
				"idProfileLiked" => $action['id_user']);
			$profileLike = new ProfileLike(0);
			$state = $profileLike->hydrate($parameters);
			if ($state === true) {
				$profileLikeManager->create($profileLike);
				$notificationManager->generateNotification("like", $action['id_user'], $currentUser->getId());
			} else {
				$error = $state;
			}
		} else {
			$profileLikeManager->deleteWithoutId($action['id_user'], $currentUser->getId());
			$notificationManager->generateNotification("unLike", $action['id_user'], $currentUser->getId());
		}
	} else {
		$error = genError("profileLike", "notlogged", "login");
	}
}