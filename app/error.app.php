<?php

function genError($action, $type, $element) {
	$error = array("action" => $action,
		"type" => $type,
		"element" => $element);

	global $db;

	$q = $db->prepare('SELECT message FROM errors WHERE (action = :action) AND (type = :type) AND (element = :element)');
	$q->bindValue(':action', $action, PDO::PARAM_STR);
	$q->bindValue(':type', $type, PDO::PARAM_STR);
	$q->bindValue(':element', $element, PDO::PARAM_STR);
	$q->execute();

	if ($q->rowCount() === 0) {
		$error['msg'] = "Erreur inconnue";
	} else {
		$msg = $q->fetch();
		$error['msg'] = $msg['message'];
	}

	return $error;
}