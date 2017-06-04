<script>
function change_visibility(fieldId) {
    if (document.getElementById(fieldId + "_edit").style.display == "none") {
       document.getElementById(fieldId + "_edit").style.display = "block";
       document.getElementById(fieldId + "_text").style.display = "none";
    } else {
       document.getElementById(fieldId + "_edit").style.display = "none";
       document.getElementById(fieldId + "_text").style.display = "block";
    }
}

function updateNames() {
    var data = {};

    data["lastname"] = document.getElementById("editLastName").value;
    data["firstname"] = document.getElementById("editFirstName").value;
    data["pageId"] = "names";
    data["type"] = "static";
    updateData(data);
}

function updateEmail() {
    var data = {};

    data["email"] = document.getElementById("editEmail").value;
    data["pageId"] = "email";
    data["type"] = "static";
    updateData(data);
}

function updatePassword() {
    var data = {};

    data["password"] = document.getElementById("editPassword").value;
    data["pageId"] = "password";
    data["type"] = "no_show";
    updateData(data);
}

function updateBio() {
    var data = {};

    data["bio"] = document.getElementById("editBio").value;
    data["pageId"] = "bio";
    data["type"] = "static";
    updateData(data);
}

function updateSexe() {
    var data = {};

    var sexe;
    if (document.getElementById('sexe_homme').checked) {
        sexe = "0";
    } else {
        sexe = "1";
    }

    data["sexe"] = sexe;
    data["pageId"] = "sexe";
    data["type"] = "static";
    updateData(data);
}

function updateOrientation() {
    var data = {};

    var orientation;
    if (document.getElementById('orientation_homme').checked) {
        orientation = "male";
    } else if (document.getElementById('orientation_femme').checked) {
        orientation = "female";
    } else if (document.getElementById('orientation_both').checked) {
        orientation = "both";
    } else {
        orientation = "notchecked";
    }

    if (orientation != "notchecked") {
        data["sexual_orientation"] = orientation;
        data["pageId"] = "orientation";
        data["type"] = "static";
        updateData(data);
    } else {
        alert("Veuillez sélectionnez votre orientation sexuelle.");
    }
}

function updateProfilePicture() {
    var data = {};

    var e = document.getElementById("profilePictureSelector");
    var response = e.options[e.selectedIndex].value;

    data["profilePicture"] = response;
    data["pageId"] = "profilePicture";
    data["type"] = "profilePicture";
    updateData(data);
}

function showNewProfilePicture(picture) {
    document.getElementById("profilePicture").src="data/userpics/" + picture + ".jpeg";
}

function updateFeaturedPictures() {
    var data = {};

    featuredPicsResponse = "";

    for (i = 0; i < 4; i++) {
        var e = document.getElementById("featuredPicturesSelector" + i);
        var strUser = e.options[e.selectedIndex].value;
        featuredPicsResponse += strUser;
        if (i < 3) {
            featuredPicsResponse += ",";
        }
    }

    data["featuredPictures"] = featuredPicsResponse;
    data["pageId"] = "featuredPictures";
    data["type"] = "featuredPictures";

    updateData(data);
}

function showNewFeaturedPictures(featuredPictures) {
    var featuredSplitted = featuredPictures.split(",");

    for (i = 0; i < 4; i++) {
        document.getElementById("featuredPicture" + i).src="data/userpics/" + featuredSplitted[i] + ".jpeg";
    }
}

function deleteTag(tagId) {
    var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var reply = ajax.responseText;
            var toShow = JSON.parse(reply);

            if (toShow['output'] == "ok") {
                document.getElementById("user_tag_" + tagId).style.display = "none";
            } else {
                alert(toShow["err_msg"]);
            }
        }
    }
    var data = {};
    data["action"] = "delete";
    data["id"] = tagId;

    var formData = new FormData();

    formData.append('action', "update_user_tag");
    formData.append('data', JSON.stringify(data));

    ajax.open('post', "action.php", true);
    ajax.send(formData);
    return ajax;
}

function addTag() {
    var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var reply = ajax.responseText;
            var toShow = JSON.parse(reply);

            if (toShow['output'] == "ok") {
                var container = document.createElement("DIV");
                container.className = "user_tag";
                container.setAttribute("id", "user_tag_" + toShow['tagId']);

                var tag_content = document.createElement("P");
                tag_content.innerText = "#" + toShow['tag_content'];

                var tag_delete = document.createElement("A");
                tag_delete.setAttribute("onclick", "deleteTag(" + toShow['tagId'] + ")");
                tag_delete.setAttribute("href", "#");
                tag_content.appendChild(tag_delete);

                var tag_delete_img = document.createElement("IMG");
                tag_delete_img.setAttribute("width", "11px");
                tag_delete_img.setAttribute("src", "assets/img/icons/delete.svg");

                tag_delete.appendChild(tag_delete_img);

                container.appendChild(tag_content);

                var c_div = document.getElementById("tagList");
                c_div.insertBefore(container, document.getElementById("add_tag"));
            } else {
                alert(toShow["err_msg"]);
            }
        }
    }
    var data = {};
    data["action"] = "add";
    data["content"] = document.getElementById("addTagField").value;

    var formData = new FormData();

    formData.append('action', "update_user_tag");
    formData.append('data', JSON.stringify(data));

    ajax.open('post', "action.php", true);
    ajax.send(formData);
    return ajax;
}

function updateData(data)
{
    var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var reply = ajax.responseText;
            var toShow = JSON.parse(reply);

            if (toShow['output'] == "ok") {
                if (data["type"] == "static") {
                    for(var n in toShow) {
                        var element = document.getElementById(n + "_field");
                        if (element != null) {
                            element.innerHTML = toShow[n];
                        }
                    }
                } else if (data["type"] == "no_show") {
                    if (data["pageId"] == "password") {
                        alert("Le mot de passe a bien été mis à jour.");
                    }
                } else if (data["type"] == "featuredPictures") {
                    showNewFeaturedPictures(toShow["featuredPictures"]);
                } else if (data["type"] == "profilePicture") {
                    showNewProfilePicture(toShow["profilePicture"]);
                }
                change_visibility(data["pageId"]);
            } else {
                alert(toShow["err_msg"]);
            }
        }
    }


    var formData = new FormData();

    formData.append('action', "updateProfilInformations");
    formData.append('data', JSON.stringify(data));
    ajax.open('post', "action.php", true);
    ajax.send(formData);
    return ajax;
}

</script>

<div id="page">
	<div id="profil_header">
		<?php include("view/profile/boxes/header.profile.view.php"); ?>
	</div>
	<div id="infos">
		<?php include("view/profile/boxes/infos.profile.view.php"); ?>
	</div>
	<div id="map">
	</div>
</div>