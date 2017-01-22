<?php

$sexeInfo = "Sexe : <span id=\"sexe_field\">" . $currentProfile->getSexeInString() . "</span>";
$orientationInfo = "Orientation sexuelle : <span id=\"sexual_orientation_field\">" . $currentProfile->getOrientationInString() . "</span>";
$bioInfo = "Bio : <span id=\"bio_field\">" . $currentProfile->getBio() . "</span>";

$tagList = $tagManager->getAllTagsFromMemberId($currentProfile->getId());
$tagsInfo = '<div id="tagList">';
foreach($tagList as $tag) {
	$tagsInfo .= '<div id="user_tag_' . $tag->getId() . '" class="user_tag">';
	$tagsInfo .= '<p>' . $tag->getContent();
	if ($ownProfile == true) {
		$tagsInfo .= " <a onclick=\"deleteTag(" . $tag->getId() . ")\" href=\"#\"><img width=\"11px\" src=\"assets/img/icons/delete.svg\"</img></a>";
	}
	$tagsInfo .= '</p></div>';
}
$tagsInfo .= '</div>';

	if ($ownProfile) {
		$sexeEdit =	"<input type=\"radio\" " . (($currentProfile->getSexe() == 0) ? "checked " : "") . "name=\"editSexe\" id=\"sexe_homme\" value=\"0\"/> <label for=\"sexe_homme\">Homme</label>
			<input type=\"radio\" " . (($currentProfile->getSexe() == 1) ? "checked " : "") . "name=\"editSexe\" id=\"sexe_femme\" value=\"1\"/> <label for=\"sexe_femme\">Femme</label>";

		$orientationEdit = "<input type=\"radio\" " . (($currentProfile->getSexual_orientation() == "male") ? "checked " : "") . "name=\"editOrientation\" id=\"orientation_homme\" value=\"0\"/> <label for=\"orientation_homme\">Homme uniquement</label>
			<input type=\"radio\" " . (($currentProfile->getSexual_orientation() == "female") ? "checked " : "") . "name=\"editOrientation\" id=\"orientation_femme\" value=\"1\"/> <label for=\"orientation_femme\">Femme uniquement</label>
			<input type=\"radio\" " . (($currentProfile->getSexual_orientation() == "both") ? "checked " : "") . "name=\"editOrientation\" id=\"orientation_both\" value=\"1\"/> <label for=\"orientation_both\">Les deux</label>";

		$bioEdit = "<textarea placeholder=\"Bio\" name=\"editBio\" id=\"editBio\">" . $currentProfile->getBio() . "</textarea>";

		$tagsEdit = "";

		echo "<p>";
		showEditableInfo("sexe", $sexeInfo, $sexeEdit);
		echo "<br />";
		showEditableInfo("orientation", $orientationInfo , $orientationEdit);
		echo "<br />";
		showEditableInfo("bio", $bioInfo , $bioEdit);
		echo "<br />";
		echo $tagsInfo;
		echo "</p>";
	} else {
		echo "<p>";
		echo "Sexe : " . $sexeInfo;
		echo "<br />";
		echo "Orientation sexuelle : " . $orientationInfo;
		echo "<br />";
		echo "Bio : " . $bioInfo;
		echo "<br />";
		echo "</p>";
	}