<script>
function change_visibility(toShowId, toHideId) {
	document.getElementById(toHideId).style.display = "none";
	document.getElementById(toShowId).style.display = "block";
}

function updateNames() {
    var data = new Array();

    data["lastname"] = document.getElementById("editLastName").value;
    data["firstname"] = document.getElementById("editFirstName").value;
    data["pageId"] = "names";
    updateData(data);
}

function updateData(data)
{
    var ajax;

    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    }
    else if (ActiveXObject("Microsoft.XMLHTTP")) {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (ActiveXObject("Msxml2.XMLHTTP")) {
        ajax = new ActiveXObject("Msxml2.XMLHTTP");
    }
    else {
        alert("Il semble que votre navigateur ne supporte pas AJAX. :(");
        return false;
    }

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            change_visibility(data["pageId"] + "_text", data["pageId"] + "_edit");
            console.log(ajax.responseText);
        }
    }


    var formData = new FormData();
    formData.append('action', "updateProfilInformations");

    for (i = 0; i < data.length; i++) {
    	formData.append(data[i][0], data[i][1]);
    }

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
	<div id="history">
	</div>
	<div id="photos">
	</div>
	<div id="likes">
	</div>
</div>