<?php
$toCheck = array("id_picture");

foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("like", "missingfield", $element);
	}
}

if (!isset($error)) {
	if (isUserLogged()) {
		$parameters = array(
			"id_user" => $currentUser->getId(),
			"id_picture" => $action['id_picture']);
		$like = new Like(0);
		$state = $like->hydrate($parameters);
		if ($state === true) {
			$likeManager = new LikeManager($db);
			$likeManager->add($like);
		} else {
			$error = $state;
		}
	} else {
		$error = genError("like", "notlogged", "login");
	}
}