<script>
function like()
{
    var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    var formData = new FormData();
    formData.append('id_user', <?php echo $currentProfile->getId();?>);
    
	formData.append('action', "likeUser");

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            if (document.getElementById("likeProfileButton").innerHTML == "Like") {
            	document.getElementById("likeProfileButton").innerHTML = "Dislike"
            } else {
            	document.getElementById("likeProfileButton").innerHTML = "Like"
            }
        }
    }

    ajax.open("POST", "action.php", true);
    ajax.send(formData);
    
    return ajax;
}

function reportUser()
{
    var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    var formData = new FormData();
    formData.append('id_user', <?php echo $currentProfile->getId();?>);
    
	formData.append('action', "reportUser");

    ajax.onreadystatechange = function() {
    	console.log(ajax.responseText);
        if (ajax.readyState == 4 && ajax.status == 200) {
        	alert("Le profil a bien été marqué comme faux.");
            document.getElementById("reportUserButton").style.visibility = "hidden";
        }
    }

    ajax.open("POST", "action.php", true);
    ajax.send(formData);
    
    return ajax;
}

</script>

<?php

$nameInfos = "<span id=\"lastname_field\">" . $currentProfile->getLastname() . "</span> <span id=\"firstname_field\">" . $currentProfile->getFirstname() . "</span>";
$mailInfo = "Email : <span id=\"email_field\">" . $currentProfile->getEmail() . "</span>";
$passwordInfo = "<a href=\"#\" onclick=\"change_visibility('password')\" /> Modifier mon mot de passe</a>";

$profilePicturePath = "assets/img/icons/no_picture.jpg";
$PPID = $currentProfile->getProfilePicture();

if ($PPID > 0) {
	$profilePicturePath = "data/userpics/" . $PPID . ".jpeg";
}

$profileLikeManager = new ProfileLikeManager($db);
$userReportManager = new UserReportManager($db);

$featuredPicturesInfos = "";
$featuredPictures = explode(",", $currentProfile->getFeaturedPictures());

$profilePictureInfo = "<img id=\"profilePicture\" width=\"150px\" src=\"" . $profilePicturePath . "\" />";

	if ($ownProfile) {
		$nameEdit =	"<input type=\"text\" name=\"editLastName\" id=\"editLastName\" value=\"" . $currentProfile->getLastname() . "\" placeholder=\"Nom\" />
		<input type=\"text\" name=\"editFirstName\" id=\"editFirstName\" placeholder=\"Prénom\" value=\"" . $currentProfile->getFirstname() . "\" />";

		$mailEdit = "<input type=\"text\" name=\"editEmail\" id=\"editEmail\" value=\"" . $currentProfile->getEmail() . "\" placeholder=\"Email\" />";

		$passwordEdit = "<input type=\"password\" name=\"editPassword\" id=\"editPassword\" placeholder=\"Votre nouveau mot de passe\" />";

		$userPictureManager = new UserPictureManager($db);
		$profilePictureEdit = '<ul>';
		$profilePictureEdit .= '<li>Utiliser une image existante : <select name="profilePictureSelector" id="profilePictureSelector">';
		$picturesFromUser = $userPictureManager->getEditedPicturesFromUser($currentProfile->getId());
		foreach($picturesFromUser as $pic) {
			$profilePictureEdit .= '<option' . (($currentProfile->getProfilePicture() == $pic['id']) ? ' selected=\"selected\" ' : '') . ' value="' . $pic['id'] . '">Image no ' . $pic['id'] . '</option>';
		}
		$profilePictureEdit .= '</select></ul>';

		echo "<p>";
		showEditableInfo("names", $nameInfos, $nameEdit);
		echo "<br />";
		showEditableInfo("profilePicture", $profilePictureInfo, $profilePictureEdit);
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
		echo "<div id=\"score\">Score de popularité : XXX<br /></div>";
		echo "<br />";
		if ($currentUser->getProfilePicture() != NULL) { ?><button onClick="like()" id="likeProfileButton"><?php if ($profileLikeManager->ifProfileIsLikedByUser($currentProfile->getId(), $currentUser->getId())) { ?>Dislike<?php } else { ?>Like<?php } ?></button><?php
		}
		if ($userReportManager->ifProfileIsAlreadyReportedByUser($currentProfile->getId(), $currentUser->getId()) != TRUE) { ?><button onClick="reportUser()" id="reportUserButton">Report User</button><?php
			}
		echo "</p>";
	}