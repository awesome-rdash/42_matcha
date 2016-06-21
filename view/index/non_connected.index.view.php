<div id="unlogscreen">
	<div id="leftscreen">
		<center><h1>CAMAGRU</h1>
		<p>Inscrivez-vous maintenant !</p></center>
			<?php 
			include("view/register/registerform.view.php"); ?>
		<div id="connectionform">
			<p>Déjà inscrit ?</p>
			<form method="POST" action="index.php?action=connexion">
				<label for="nickname">Nom d'utilisateur : </label>
				<input type="text" name="nickname" id="nickname" maxlength="15" required <?php if (isset($_POST['nickname'])) { echo "value=\"" . $_POST['nickname'] . "\"" ; } ?> />
				<br />

				<label for="password">Email : </label>
				<input type="password" name="password" id="password" maxlength="255" required <?php if (isset($_POST['password'])) { echo "value=\"" . $_POST['password'] . "\"" ; } ?> />
				<br />
				<input type="submit" value="Connexion">
			</form>
		</div>
	</div>
</div>