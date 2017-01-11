<div id="registerform">
<?php 
	if (isset($error) && $error['module'] == "register") { echo "<p id=\"errormsg\">" . $error['msg'] . "</p>"; }
?>
	<form method="post" action="index.php?action=register">
		<fieldset>
			<legend>Informations de connexion</legend>
			<label for="nickname">Nom d'utilisateur : </label>
			<input type="text" name="nickname" id="nickname" maxlength="15" required <?php if (isset($_POST['nickname'])) { echo "value=\"" . $_POST['nickname'] . "\"" ; } ?> />
			<br />

			<label for="email">Email : </label>
			<input type="email" name="email" id="email" maxlength="255" required <?php if (isset($_POST['email'])) { echo "value=\"" . $_POST['email'] . "\"" ; } ?> />
			<br />

			<label for="password">Mot de passe : </label>
			<input type="password" name="password" id="password" maxlength="16" required />
			<br />

			<label for="password2">Confirmation du mot de passe : </label>
			<input type="password" name="password2" id="password2" maxlength="16" required />
		</fieldset>
			<fieldset>
				<legend>Dites-en plus sur vous</legend>
				<label for="lastname">Nom : </label>
				<input type="text" name="lastname" id="lastname" maxlength="25" required <?php if (isset($_POST['lastname'])) { echo "value=\"" . $_POST['lastname'] . "\"" ; } ?> />
				<br />

				<label for="firstname">Prénom : </label>
				<input type="text" name="firstname" id="firstname" maxlength="25" required <?php if (isset($_POST['firstname'])) { echo "value=\"" . $_POST['firstname'] . "\"" ; } ?> />
				<br />

				<label for="sex">Sexe : </label>
				<input type="radio" name="sex" id="sex_female" value="sex_female" required /> <label for="sex_female">Femme</label>
				<input type="radio" name="sex" id="sex_male" value="sex_male" required /> <label for="sex_male">Homme</label>
				<br />

				<label for="sex_orientation">Orientation sexuelle : </label>
				<input type="radio" name="sex_orientation" id="sex_orientation_female" value="sex_orientation_female" required /> <label for="sex_orientation_female">Femmes uniquement</label>
				<input type="radio" name="sex_orientation" id="sex_orientation_male" value="sex_orientation_male" required /> <label for="sex_orientation_male">Hommes uniquement</label>
				<input type="radio" name="sex_orientation" id="sex_orientation_both" value="sex_orientation_both" required /> <label for="sex_orientation_both">Hommes et Femmes </label>
				<br />

				<label for="bio">Bio : </label>
				<textarea name="bio" id="bio" rows="10" cols="50" placeholder="Dites-en plus à nos membres"></textarea>   
			</fieldset>
		<center><input type="submit" name="submit" value="S'inscrire">
	</form>
</div>