<?php

$nameInfos = $currentProfile->getLastname() . " " . $currentProfile->getFirstname();

	if ($ownProfile) {
		$nameEdit =	"<input type=\"text\" name=\"editLastName\" id=\"editLastName\" value=\"" . $currentProfile->getLastname() . "\" placeholder=\"Nom\" />
		<input type=\"text\" name=\"editFirstName\" id=\"editFirstName\" placeholder=\"Prénom\" value=\"" . $currentProfile->getFirstname() . "\" /> <input type=\"button\" value=\"Modifier\" onclick=\"updateNames()\"";
	?>

	<p>
		<?php showEditableInfo("names", $nameInfos, $nameEdit) ;?> <br />

		<div id="score">Mon score de popularité : XXX<br /></div>
		Email : <?php echo $currentProfile->getEmail();?><br />
		Modifier mon mot de passe
	</p>
<?php
	} else {
?>

<?php
}