<script>
function change_visibility(toShowId, toHideId) {
	document.getElementById(toHideId).style.display = "none";
	document.getElementById(toShowId).style.display = "block";
}

function updateNames() {
    var data = {};

    data["lastname"] = document.getElementById("editLastName").value;
    data["firstname"] = document.getElementById("editFirstName").value;
    data["pageId"] = "names";
    data["type"] = "static";
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
            var reply = ajax.responseText;
            var toShow = JSON.parse(reply);

            if (toShow['output'] == "ok") {
                if (data["type"] == "static") {
                    for(var n in toShow) {
                        var element = document.getElementById(n);
                        if (element != null) {
                            element.innerHTML = toShow[n];
                        }
                    }
                }
                change_visibility(data["pageId"] + "_text", data["pageId"] + "_edit");
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
	<div id="history">
	</div>
	<div id="photos">
	</div>
	<div id="likes">
	</div>
</div>