<?php

$error = false;
$json_output = array("output" => "ok");

if (isset($_POST['data']) && !empty($_POST['data'])) {
	$data = json_decode($_POST['data'], true);
} else {
	$error = "no_data";
}

if ($error === false) {
	$tagManager = new TagManager($db);
	if ($data['action'] == 'delete') {
		$tagManager->deleteTagLink($currentUser->getId(), (int)($data['id']));
	} else if ($data['action'] == 'add'){
		$tag = $tagManager->get("content", $data['content']);
		if ($tag == false) {
			$newTag = new Tag(0);
			$return = $newTag->setContent($data['content']);
			if ($return != true) {
				$error = $return;
				print_r($return);
			} else {
				$tagId = $tagManager->add($newTag);
				$tag->setId($tagId);
			}
		}
	}
}

if ($error === false) {
	$tagManager->addLink($currentUser->getId(), $tag->getId());
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