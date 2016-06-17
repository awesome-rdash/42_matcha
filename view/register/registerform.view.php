<div id="registerform">
<?php if (isset($error)) { echo "<p id=\"errormsg\">" . $error['msg'] . "</p><br />";}
?>
	<form method="post" action="index.php?action=register">
		<fieldset>
			<legend>Informations de connexion</legend>
			<label for="nickname">Nom d'utilisateur : </label>
			<input type="text" name="nickname" id="nickname" maxlength="15" required />
			<br />

			<label for="email">Email : </label>
			<input type="email" name="email" id="email" maxlength="255" required />
			<br />

			<label for="password">Mot de passe : </label>
			<input type="password" name="password" id="password" maxlength="16" required />
			<br />

			<label for="password2">Confirmation du mot de passe : </label>
			<input type="password" name="password2" id="password2" maxlength="16" required />
		</fieldset>
		<fieldset>
			<legend>A propos de vous</legend>
			<label for="lastname">Nom : </label>
			<input type="text" name="lastname" id="lastname" maxlength="255"/>
			<br />

			<label for="firstname">Prénom : </label>
			<input type="text" name="firstname" id="firstname" maxlength="255"/>
			<br />

			<label for="birthdate">Date de naissance : </label>
			<input type="date" name="birthdate" id="birthdate" required />
		</fieldset>
		<center><input type="submit" name="submit" value="S'inscrire">
	</form>
</div>