<?php

$error = false;
$json_output = array("output" => "ok");
$json_output["time"] = time();
if (isset($_POST['data']) && !empty($_POST['data'])) {
	$data = json_decode($_POST['data'], true);
} else {
	$error = "no_data";
}

$notificationManager = new notificationManager($db);

if ($error === false) {
	$json_output['info'] = $data['info'];
	if ($data['info'] == "count") {
		$json_output["count"] = $notificationManager->getUnreadNotificationsCount($currentUser->getId());
		if ($data['lastCallTime'] != 0) {
			$newNotifs = $notificationManager->notificationsBetweenTwoTimestamp($currentUser->getId());
		}
	}
}

if ($error) {
	if (is_array($error)) {
		$json_output["err_msg"] = $error['msg'];
	} else {
		$json_output["err_msg"] = "Une erreur est survenue. Nous nous excusons de la gêne occasionnée";
	}
	$json_output["output"] = "error";
}

echo json_encode($json_output);