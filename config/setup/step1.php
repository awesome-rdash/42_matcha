<?php
$error = 0;
if (isset($_POST['password'])) {
	$password = hash("whirlpool", $_POST['password']);
	if ($password === "838858b5bb0592b88fef9c3a67a97546949687b8d45e505a50c203d064c0306be286d20d5f41b2d1cecd613e8c410c49031db7b878629761b64691d11ced1a58") {
		$_SESSION['logged'] = true;
		header ("Location: setup.php?step=2");
	}
	else
	{
		$error = 1;
	}
}
?>
<html>
	<head>
		<title>DANGER ZONE</title>
		<meta charset="utf-8">
	</head>
	<body>
		<div id="page">
		<?php if ($error) { echo "<p><font color=\"red\">Erreur : le mot de passe entré est incorrect. :(</font></p>"; } ?>
			<h1>DANGER ZONE</h1>
			<p>Cette partie du site vous sert à configurer ou réinitialiser votre application. Avant d'aller plus loin, gardez en tête que TOUT SERA REINITAILISE si vous continuez.</p>
			<p>Entrez votre mot de passe super-admin ici.</p>
			<form method="post" action="setup.php?step=1">
				<input type="password" name="password" required>
				<input type="submit" value="Se connecter" name="submit">
			</form>
		</div>
	</body>
</html>