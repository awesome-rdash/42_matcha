<div id="resetpasswordform">
<?php 
	if (isset($error) && $error['module'] == "resetpassword") { echo "<p id=\"errormsg\">" . $error['msg'] . "</p>"; }
?>
	<form method="post" action="index.php?action=resetpassword">

		<label for="email">Email utilisé lors de l'inscription : </label>
		<input type="email" name="email" id="email" maxlength="255" required <?php if (isset($_POST['email'])) { echo "value=\"" . $_POST['email'] . "\"" ; } ?> />
		<br />

		<center><input type="submit" name="submit" value="Réinitialiser mon mot de passe">
	</form>
</div>