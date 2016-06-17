<?php

function genError($action, $type, $element) {
	$error = array("action" => $action,
		"type" => $type,
		"element" => $element);

	$error["msg"] = "Erreur inconnue.";
	switch ($type) {
		case "missingfield": {
			switch ($element) {
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

		case "alreadyexist": {
			switch ($element) {
				case "nickname":
					$error["msg"] = "Le nom d'utilisateur que vous avez choisi existe déjà.";
					break;

				case "email":
					$error["msg"] = "L'email que vous avez entrée est déjà associée à un autre compte.";
					break;

			}
			break;
		}
		break;
	}
	return $error;
}