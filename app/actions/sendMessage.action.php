<?php

$error = false;
$json_output = array("output" => "ok");

if (isset($_POST['data']) && !empty($_POST['data'])) {
	$data = json_decode($_POST['data'], true);
} else {
	$error = "no_data";
}

if ($error === false) {
	$message = new Message(0);
	$hydrate_return = $message->hydrate($data);
	if ($hydrate_return !== true) {
		$error = $hydrate_return;
	}
	if ($error === false) {
		$message->setFromUser($currentUser->getId());
		$message->setNew(1);
		$messageManager = new MessageManager($db);
		$msgID = $messageManager->create($message);
		$json_output['messageContent'] = $message->getContent();
		$json_output['messageId'] = $message->getId();
	}
}

if ($error !== false) {
	if (is_array($error)) {
		$json_output["err_msg"] = $error['msg'];
	} else {
		$json_output["err_msg"] = "Une erreur est survenue. Nous nous excusons de la gêne occasionnée";
	}
	$json_output["output"] = "error";
}

echo json_encode($json_output);