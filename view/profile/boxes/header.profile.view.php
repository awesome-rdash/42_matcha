<?php

$nameInfos = "<span id=\"lastname\">" . $currentProfile->getLastname() . "</span> <span id=\"firstname\">" . $currentProfile->getFirstname() . "</span>";
$mailInfo = "<span id=\"email\">" . $currentProfile->getEmail() . "</span>";

	if ($ownProfile) {
		$nameEdit =	"<input type=\"text\" name=\"editLastName\" id=\"editLastName\" value=\"" . $currentProfile->getLastname() . "\" placeholder=\"Nom\" />
		<input type=\"text\" name=\"editFirstName\" id=\"editFirstName\" placeholder=\"Prénom\" value=\"" . $currentProfile->getFirstname() . "\" /> <input type=\"button\" value=\"Modifier\" onclick=\"updateNames()\"";

		$mailEdit = "<input type=\"text\" name=\"editEmail\" id=\"editEmail\" value=\"" . $currentProfile->getLastname() . "\" placeholder=\"Email\" /> <input type=\"button\" value=\"Modifier\" onclick=\"updateEmail()\" />"
	?>

	<p>
		<?php showEditableInfo("names", $nameInfos, $nameEdit) ;?> <br />

		<div id="score">Mon score de popularité : XXX<br /></div>

		Email : <?php showEditableInfo("email",$mailInfo , $mailEdit) ;?> <br />
		Modifier mon mot de passe
	</p>
<?php
	} else {
?>

<?php
}