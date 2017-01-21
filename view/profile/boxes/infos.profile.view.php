<?php

$sexeInfo = "Sexe : <span id=\"sexe_field\">" . $currentProfile->getSexeInString() . "</span>";
$orientationInfo = "Orientation sexuelle : <span id=\"orientation_field\">" . $currentProfile->getOrientationInString() . "</span>";
$bioInfo = "Bio : <span id=\"bio\">" . $currentProfile->getBio() . "</span>";

	if ($ownProfile) {
		$sexeEdit =	"<input type=\"radio\" name=\"editSexe\" id=\"sexe_homme\" value=\"0\"/> <label for=\"sexe_homme\">Homme</label>
			<input type=\"radio\" name=\"editSexe\" id=\"sexe_femme\" value=\"1\"/> <label for=\"sexe_femme\">Femme</label>";

		$orientationEdit = "<input type=\"text\" name=\"editEmail\" id=\"editEmail\" value=\"" . $currentProfile->getLastname() . "\" placeholder=\"Email\" /> <input type=\"button\" value=\"Modifier\" onclick=\"updateEmail()\" />";

		$bioEdit = "<input type=\"password\" name=\"editPassword\" id=\"editPassword\" placeholder=\"Votre nouveau mot de passe\" /> <input type=\"button\" value=\"Modifier\" onclick=\"updatePassword()\" />";
		echo "<p>";
		showEditableInfo("sexe", $sexeInfo, $sexeEdit);
		echo "<br />";
		showEditableInfo("orientation", $orientationInfo , $orientationEdit);
		echo "<br />";
		showEditableInfo("bio", $bioInfo , $bioEdit);
		echo "<br />";
		echo "</p>";
	} else {
		echo "<p>";
		echo "<div>" . $nameInfos . "</div>";
		echo "<div id=\"score\">Mon score de popularité : XXX<br /></div>";
		echo "<br />";
		echo "</p>";
	}