<?php

function genError($module, $type, $element) {
	$error = array("module" => $module,
		"type" => $type,
		"element" => $element);

	global $db;

	$q = $db->prepare('SELECT message FROM errors WHERE (module = :module) AND (type = :type) AND (element = :element)');
	$q->bindValue(':module', $module, PDO::PARAM_STR);
	$q->bindValue(':type', $type, PDO::PARAM_STR);
	$q->bindValue(':element', $element, PDO::PARAM_STR);
	$q->execute();

	if ($q->rowCount() === 0) {
		$error['msg'] = "Erreur inconnue. Le problème a eu lieu dans le module  " . $module . " sur l'élément " . $element . " à cause de " . $type . ".";
		//$error['msg'] = "Il y a eu une erreur. Veuillez nous excuser.";
	} else {
		$msg = $q->fetch();
		$error['msg'] = $msg['message'];
	}

	return $error;
}