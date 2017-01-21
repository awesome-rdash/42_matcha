<?php

$error = false;

if (isset($_POST['data']) && !empty($_POST['data'])) {
	$data = json_decode($_POST['data'], true);
} else {
	$error = "no_data";
}

if ($error === false) {
	$memberManager = new MemberManager($db);
	$parameters = array();
	$return = $currentUser->hydrate($data);
	if ($return !== true) {
		$error = $return;
	}
}

if ($error === false) {
	$memberManager->update($currentUser);
	$json_output = array();
	foreach ($data as $key => $value) {
		$method = "get" . ucfirst($key);
		if (method_exists($currentUser, $method) && isset($value)) {
			$result = $currentUser->$method();
			if ($result != NULL) {
				$json_output[$key] = $result;
			}
		}
	}

	echo json_encode($json_output);
}