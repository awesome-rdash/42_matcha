<?php
$toCheck = array("id_user");

foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("like", "missingfield", $element);
	}
}

if (!isset($error)) {
	if (isUserLogged() && $currentUser->getProfilePicture() != NULL) {
		$profileLikeManager = new ProfileLikeManager($db);
		if (!($profileLikeManager->ifProfileIsLikedByUser($action['id_user'], $currentUser->getId()))) {
			$parameters = array(
				"idUser" => $currentUser->getId(),
				"idProfileLiked" => $action['id_user']);
			$profileLike = new ProfileLike(0);
			$state = $profileLike->hydrate($parameters);
			if ($state === true) {
				$profileLikeManager->create($profileLike);
			} else {
				$error = $state;
			}
		} else {
			$profileLikeManager->deleteWithoutId($action['id_user'], $currentUser->getId());
		}
	} else {
		$error = genError("profileLike", "notlogged", "login");
	}
}