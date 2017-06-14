<?php

$error = false;
$json_output = array("output" => "ok");
$json_output["time"] = time();
if (isset($_POST['data']) && !empty($_POST['data'])) {
	$data = json_decode($_POST['data'], true);
} else {
	$error = "no_data";
}

$messageManager = new MessageManager($db);
$memberManager = new MemberManager($db);

if ($error === false) {
	$json_output['info'] = $data['info'];
	if ($data['info'] == "messagesBetweenTwoUsers") {
		$currentProfile = $memberManager->getFromID($data['fromUser']);
		$json_output['content'] = $messageManager->getMessagesBetweenTwoTimestamp($currentUser->getId(), $currentProfile->getId(), $data['lastCallTime'], time());
	}
}

if ($error) {
	$json_output["output"] = "notok";
	if (is_array($error)) {
		$json_output["err_msg"] = $error['msg'];
	} else {
		$json_output["err_msg"] = "Une erreur est survenue. Nous nous excusons de la gêne occasionnée";
	}
	$json_output["output"] = "error";
}

echo json_encode($json_output);