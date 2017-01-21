<?php

$nameInfos = "<span id=\"lastname\">" . $currentProfile->getLastname() . "</span> <span id=\"firstname\">" . $currentProfile->getFirstname() . "</span>";
$mailInfo = "Email : <span id=\"email\">" . $currentProfile->getEmail() . "</span>";
$passwordInfo = "<a href=\"#\" onclick=\"change_visibility('password')\" /> Modifier mon mot de passe</a>";

	if ($ownProfile) {
		$nameEdit =	"<input type=\"text\" name=\"editLastName\" id=\"editLastName\" value=\"" . $currentProfile->getLastname() . "\" placeholder=\"Nom\" />
		<input type=\"text\" name=\"editFirstName\" id=\"editFirstName\" placeholder=\"Prénom\" value=\"" . $currentProfile->getFirstname() . "\" /> <input type=\"button\" value=\"Modifier\" onclick=\"updateNames()\" />";

		$mailEdit = "<input type=\"text\" name=\"editEmail\" id=\"editEmail\" value=\"" . $currentProfile->getLastname() . "\" placeholder=\"Email\" /> <input type=\"button\" value=\"Modifier\" onclick=\"updateEmail()\" />";

		$passwordEdit = "<input type=\"password\" name=\"editPassword\" id=\"editPassword\" placeholder=\"Votre nouveau mot de passe\" /> <input type=\"button\" value=\"Modifier\" onclick=\"updatePassword()\" />";
	?>

	<p>
		<?php showEditableInfo("names", $nameInfos, $nameEdit) ;?> <br />

		<div id="score">Mon score de popularité : XXX<br /></div>

		<?php showEditableInfo("email", $mailInfo , $mailEdit) ;?> <br />
		<?php showEditableInfo("password", $passwordInfo , $passwordEdit) ;?> <br />
	</p>
<?php
	} else {
?>

<?php
}