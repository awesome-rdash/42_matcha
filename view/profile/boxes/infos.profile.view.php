<?php

$sexeInfo = "Sexe : <span id=\"sexe_field\">" . $currentProfile->getSexeInString() . "</span>";
$orientationInfo = "Orientation sexuelle : <span id=\"sexual_orientation_field\">" . $currentProfile->getOrientationInString() . "</span>";
$bioInfo = "Bio : <span id=\"bio_field\">" . htmlspecialchars($currentProfile->getBio()) . "</span>";

$tagList = $tagManager->getAllTagsFromMemberId($currentProfile->getId());
$tagsInfo = '<div id="tagList">';
foreach($tagList as $tag) {
	$tagsInfo .= '<div id="user_tag_' . $tag->getId() . '" class="user_tag">';
	$tagsInfo .= '<p>#' . $tag->getContent();
	if ($ownProfile == true) {
		$tagsInfo .= " <a onclick=\"deleteTag(" . $tag->getId() . ")\" href=\"#\"><img width=\"11px\" src=\"assets/img/icons/delete.svg\" ></a>";
	}
	$tagsInfo .= '</p></div>';
}

if ($ownProfile == true) {
	$tagsAutocomplete = "";
	$tagList = $tagManager->getAllExistingTags();
	foreach ($tagList as $tag) {
		$tagsAutocomplete .= $tag->getContent() . ", ";
	}

	$tagsAutocomplete = rtrim($tagsAutocomplete, ', ');
	$tagsInfo .= '<div id="add_tag" class="user_tag">
	<input type="text" name="addTagField" id="addTagField" placeholder="Ajouter un TAG" class="awesomplete" data-list="' . $tagsAutocomplete . '"/>
	<input type="button" value="Ajouter" onclick="addTag()"/>
	</div>
	';
}

$fp_from_db = explode(",", $currentProfile->getFeaturedPictures());
$userPictureManager = new UserPictureManager($db);

$featuredPicturesInfos = "";
$invalidPictureText = "<a href=\"#\"><img class=\"featuredPicture\" src=\"assets/img/icons/no_picture.jpg\" /></a>";

for($i = 0; $i < 4; $i++) {
	if (isset($fp_from_db[$i]) && !empty($fp_from_db[$i]) && is_numeric($fp_from_db[$i])) {
		$is_picture_valid = $userPictureManager->ifExist($fp_from_db[$i]);
		if ($is_picture_valid) {
			$featuredPicturesInfos .= "<a href=\"#\"><img id=\"featuredPicture" . $i . "\" class=\"featuredPicture\" src=\"data/userpics/" . $fp_from_db[$i] . ".jpeg\" /></a>";
		} else {
			$featuredPicturesInfos .= $invalidPictureText;
		}
	} else {
		$featuredPicturesInfos .= $invalidPictureText;
	}
}

$tagsInfo .= '</div>';

	if ($ownProfile) {
		$sexeEdit =	"<input type=\"radio\" " . (($currentProfile->getSexe() == 0) ? "checked " : "") . "name=\"editSexe\" id=\"sexe_homme\" value=\"0\"/> <label for=\"sexe_homme\">Homme</label>
			<input type=\"radio\" " . (($currentProfile->getSexe() == 1) ? "checked " : "") . "name=\"editSexe\" id=\"sexe_femme\" value=\"1\"/> <label for=\"sexe_femme\">Femme</label>";

		$orientationEdit = "<input type=\"radio\" " . (($currentProfile->getSexual_orientation() == "male") ? "checked " : "") . "name=\"editOrientation\" id=\"orientation_homme\" value=\"0\"/> <label for=\"orientation_homme\">Homme uniquement</label>
			<input type=\"radio\" " . (($currentProfile->getSexual_orientation() == "female") ? "checked " : "") . "name=\"editOrientation\" id=\"orientation_femme\" value=\"1\"/> <label for=\"orientation_femme\">Femme uniquement</label>
			<input type=\"radio\" " . (($currentProfile->getSexual_orientation() == "both") ? "checked " : "") . "name=\"editOrientation\" id=\"orientation_both\" value=\"1\"/> <label for=\"orientation_both\">Les deux</label>";

		$bioEdit = "<textarea placeholder=\"Bio\" name=\"editBio\" id=\"editBio\">" . $currentProfile->getBio() . "</textarea>";

		$featuredPicturesEdit = '<ul>';
		$explodedPictures = explode(',', $currentProfile->getFeaturedPictures());
		for($i = 0; $i < 4; $i++) {
			$featuredPicturesEdit .= '<li>Utiliser une image existante : <select name="featuredPicturesSelector' . $i . '" id="featuredPicturesSelector' . $i . '">';
			$picturesFromUser = $userPictureManager->getEditedPicturesFromUser($currentProfile->getId());
			foreach($picturesFromUser as $pic) {
				$selected = false;
				if (isset($explodedPictures[$i]) && $explodedPictures[$i] == $pic['id']) {
					$selected = true;
				}
				$featuredPicturesEdit .= '<option' . (($selected) ? ' selected=\"selected\" ' : '') . ' value="' . $pic['id'] . '">Image no ' . $pic['id'] . '</option>';
			}
			$featuredPicturesEdit .= '</select></li>';
		}

		echo "<p>";
		showEditableInfo("sexe", $sexeInfo, $sexeEdit);
		echo "<br />";
		showEditableInfo("orientation", $orientationInfo , $orientationEdit);
		echo "<br />";
		showEditableInfo("bio", $bioInfo , $bioEdit);
		echo "<br />";
		echo $tagsInfo;
		echo "<br />";
		showEditableInfo("featuredPictures", $featuredPicturesInfos, $featuredPicturesEdit);
		echo "</div>";
		echo "</p>";
	} else {
		echo "<p>";
		echo $sexeInfo;
		echo "<br />";
		echo $orientationInfo;
		echo "<br />";
		echo $bioInfo;
		echo "<br />";
		echo $featuredPicturesInfos;
		echo "<br />";
		echo "</p>";
	}

$userManager = new MemberManager($db);

$profileLikeManager = new ProfileLikeManager($db);
$likedUsers = $profileLikeManager->getListOfUserLikes($currentProfile->getId());
$total_count = count($likedUsers);
if ($total_count == 0) {
	echo "Votre profil n'a pas encore été aimé.";
} else {
	echo "Votre profil est aimé par : ";
}
$count = 0;
foreach($likedUsers as $like) {
	$likeUser = $userManager->getFromId($like->getIdUser());
	echo "<a href=\"" . Utilities::getAddress() . "profile.php?member=" . $likeUser->getId() . "\">". $likeUser->getFirstname() . " " . $likeUser->getLastname() . "</a>";
	if ($count < $total_count - 1) {
		echo (" - ");
	} else {
		echo ".";
	}
}

$profileVisitsManager = new ProfileVisitManager($db);
$visitedUsers = $profileVisitsManager->getListOfUserVisits($currentProfile->getId());
$total_count = count($visitedUsers);
if ($total_count == 0) {
	echo "Votre profil n'a pas encore été visité.";
} else {
	echo "Votre profil a été récemment visité par : ";
}
$count = 0;
foreach($visitedUsers as $visit) {
	$VisitUser = $visitedUser->getFromId($visit->getIdUser());
	echo "<a href=\"" . Utilities::getAddress() . "profile.php?member=" . $visitUser->getId() . "\">". $visitUser->getFirstname() . " " . $visitUser->getLastname() . "</a>";
	if ($count < $total_count - 1) {
		echo (" - ");
	} else {
		echo ".";
	}
}