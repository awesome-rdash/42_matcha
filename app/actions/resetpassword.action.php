<?php
$toCheck = array("email");

foreach($toCheck as $element) {
	if (!isset($_POST[$element]) || empty($_POST[$element])) {
		$error = genError("resetpassword", "missingfield", $element);
	}
}

if (!isset($error)) {
	$member_manager = new MemberManager($db);
	$member = $member_manager->get("email", htmlspecialchars($_POST["email"]));
	if (!is_object($member)) {
		$error = genError("resetpassword", "notfound", "email");
	}
}

if (!isset($error)) {
	$confirmationToken = new Token(0);
	$parameters = array(
		"user_id" => $member->getId(),
		"usefor" => "resetpassword");
	$confirmationToken->hydrate($parameters);
	$manager = new TokenManager($db);

	$manager->add($confirmationToken);

	$message = "Lien : " . Utilities::getAdress() . "index.php?action=useToken&token=" . $confirmationToken->getToken();

	utilities::sendMail($member->getEmail(), "Réinitialisation du mot de passe", $message);
}

if (isset($error)) {
	$error['module'] = "resetpassword";
}