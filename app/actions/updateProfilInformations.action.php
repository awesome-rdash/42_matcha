<?php

$error = false;
$json_output = array("output" => "ok");

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
	foreach ($data as $key => $value) {
		$method = "get" . ucfirst($key);
		if (method_exists($currentUser, $method) && isset($value)) {
			$result = $currentUser->$method();
			if ($result != NULL) {
				$json_output[$key] = $result;
			}
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