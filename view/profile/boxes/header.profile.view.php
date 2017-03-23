<?php

$nameInfos = "<span id=\"lastname_field\">" . $currentProfile->getLastname() . "</span> <span id=\"firstname_field\">" . $currentProfile->getFirstname() . "</span>";
$mailInfo = "Email : <span id=\"email_field\">" . $currentProfile->getEmail() . "</span>";
$passwordInfo = "<a href=\"#\" onclick=\"change_visibility('password')\" /> Modifier mon mot de passe</a>";

$profilePicturePath = "data/userpics/3.jpeg";
$PPID = $currentProfile->getProfilPicture();
echo "test:";
print_r($PPID);
if ($PPID > 0) {
	echo "test";
	$userPictureManager = new UserPictureManager($bdd);
	$cProfilePicture = $userPictureManager->get($PPID);
	if (is_object($cProfilePicture)) {
		$profilePicturePath = "data/userpics/" . $cProfilePicture->getId() . ".jpeg";
	}
}

$profilePictureInfo = "<img width=\"150px\" src=\"" . $profilePicturePath . "\" />";

	if ($ownProfile) {
		$nameEdit =	"<input type=\"text\" name=\"editLastName\" id=\"editLastName\" value=\"" . $currentProfile->getLastname() . "\" placeholder=\"Nom\" />
		<input type=\"text\" name=\"editFirstName\" id=\"editFirstName\" placeholder=\"Prénom\" value=\"" . $currentProfile->getFirstname() . "\" />";

		$mailEdit = "<input type=\"text\" name=\"editEmail\" id=\"editEmail\" value=\"" . $currentProfile->getEmail() . "\" placeholder=\"Email\" />";

		$passwordEdit = "<input type=\"password\" name=\"editPassword\" id=\"editPassword\" placeholder=\"Votre nouveau mot de passe\" />";
		echo "<p>";
		showEditableInfo("names", $nameInfos, $nameEdit);
		echo "<div>" . $profilePictureInfo . "</div>";
		echo "<br />";
		echo "<div id=\"score\">Mon score de popularité : XXX<br /></div>";
		showEditableInfo("email", $mailInfo , $mailEdit);
		echo "<br />";
		showEditableInfo("password", $passwordInfo , $passwordEdit);
		echo "<br />";
		echo "</p>";
	} else {
		echo "<p>";
		echo "<div>" . $nameInfos . "</div>";
		echo "<div>" . $profilePictureInfo . "</div>";
		echo "<div id=\"score\">Mon score de popularité : XXX<br /></div>";
		echo "<br />";
		echo "</p>";
	}