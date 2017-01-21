<script>
function change_visibility(toShowId, toHideId) {
	document.getElementById(toHideId).style.display = "none";
	document.getElementById(toShowId).style.display = "block";
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
</div>4