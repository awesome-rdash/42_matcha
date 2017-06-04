<?php
$toCheck = array("id_user");

foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("reportUser", "missingfield", $element);
	}
}

if (!isset($error)) {
	if (isUserLogged()) {
		$userReportManager = new UserReportManager($db);
		$action['id_user'] = (int)$action['id_user'];
		if (!($userReportManager->ifProfileIsAlreadyReportedByUser($action['id_user'], $currentUser->getId()))) {
			$parameters = array(
				"fromUser" => $currentUser->getId(),
				"toUserReported" => $action['id_user']);
			$userReport = new UserReport(0);
			$state = $userReport->hydrate($parameters);
			if ($state === true) {
				$userReportManager->create($userReport);
			} else {
				$error = $state;
			}
		}
	} else {
		$error = genError("reportUser", "notlogged", "login");
	}
}