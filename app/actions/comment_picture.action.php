<?php
$toCheck = array("id_picture", "content");

foreach($toCheck as $element) {
	if (!isset($action[$element]) || empty($action[$element])) {
		$error = genError("comment", "missingfield", $element);
	}
}

if (!isset($error)) {
	if (isUserLogged()) {
		$parameters = array(
			"id_user" => $currentUser->getId(),
			"id_picture" => $action['id_picture'],
			"content" => $action['content']);
		$comment = new Comment(0);
		$state = $comment->hydrate($parameters);
		if ($state === true) {
			$commentManager = new CommentManager($db);
			$commentManager->add($comment);
			$imageLink = Utilities::getAdress() . "picture.php?pic=" . $action['id_picture'];
			$mail = 
			ucfirst($currentUser->getNickname()) . " a poste un nouveau commentaire sur votre photo : \"" . $comment->getContent() . "\"\nCliquez ici pour le voir : $imageLink";
			Utilities::sendMail($currentUser->getEmail(),
				"Votre photo a recu un nouveau commentaire",
				$mail);
			echo $comment->getContent();
		} else {
			$error = $state;
		}
	} else {
		$error = genError("comment", "notlogged", "login");
	}
}
