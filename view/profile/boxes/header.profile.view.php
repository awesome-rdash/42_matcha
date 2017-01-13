<?php
	if ($ownProfile) {

	?>
	<p>
		<?php echo $currentProfile->getLastname() . " " . $currentProfile->getFirstname(); ?> <br />
		Mon score de popularité : XXX<br />
		Email : <?php echo $currentProfile->getEmail();?><br />
		Modifier mon mot de passe
	</p>
<?php
	} else {
?>

<?php
}