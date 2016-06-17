<?php

$return = Member::newMemberFromRegistration($_POST);

if (is_object($return)) {
	$member = $return;

} else {
	$error = $return;
}

if (isset($error)) {
	$error["action"] = "register";
	switch ($error['type']) {
		case "non-present": {
			switch ($error["element"]) {
				case "nickname":
					$error["msg"] = "Vous devez entrer un nom d'utilisateur.";
					break;

				case "email":
					$error["msg"] = "Vous devez entrer un email valide.";
					break;

				case "password":
					$error["msg"] = "Vous devez entrer un mot de passe.";
					break;

				case "password2":
					$error["msg"] = "Vous devez entrer la confirmation du mot de passe.";
					break;

				case "birthdate":
					$error["msg"] = "Vous devez entrer votre date de naissance.";
				break;

				default:
					$error["msg"] = "Un champs n'a pas été rempli.";
					break;
			}
			break;
			}
			break;

		case "notthesame":
			$error['msg'] = "Les mots de passe ne correspondent pas.";
			break;

		default:
			$error["msg"] = "Erreur inconnue.";
			break;
	}
}