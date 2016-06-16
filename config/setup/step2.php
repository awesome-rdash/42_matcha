<?php
if (!isset($_SESSION[logged]) || $_SESSION[logged] != true) {
	header("Location: setup.php");
}

$error = 0;
if (isset($_POST['submit'])) {
	if (isset($_POST['dbsrvname']) && isset($_POST['dbusername']) && isset($_POST['dbpasswd']) && isset($_POST['dbport']) && isset($_POST['dbname'])) {
		if ($_POST['dbsrvname'] !== "" && $_POST['dbname'] !== "" && $_POST['dbusername'] !== "" && $_POST['dbpasswd'] !== "" && $_POST['dbport'] !== "") {
			try {
				$bdd = new PDO('mysql:host=' . htmlspecialchars($_POST['dbsrvname']) .
					';dbname=' . $_POST['dbname'] .
					';charset=utf8',
					htmlspecialchars($_POST['dbsrvname']),
					htmlspecialchars($_POST['dbpasswd']));
				$tosave = array(
					'db_host' => $_POST['dbsrvname'],
					'db_username' => $_POST['dbusername'],
					'db_passwd' => $_POST['dbpasswd'],
					'db_name' => $_POST['dbname'],
					'db_port' => $_POST['dbport']);
				write_ini_file($tosave, "cfg.ini");
				header("Location: setup.php?step=3");
			} catch (Exception $e) {
				$error = 1;
			}
		}
	}
	$error = 1;
}
?>
<html>
	<head>
		<title>Installation du site</title>
		<meta charset="utf-8">
	</head>
	<body>
		<div id="page">
		<?php if ($error) { echo "<p><font color=\"red\">Erreur : Connexion impossible à la base de données. Veuillez vérifiez vos informations.<br /></font></p>"; echo $e;} ?>
			<h1>Connexion à la base de données</h1>
			<p>Entrez les paramètres de votre base de données</p>
			<form action="setup.php?step=2" method="POST">
				<fieldset>
					<legend>Informations du serveur</legend>

					<label for="dbsrvadress">Adresse du serveur : </label>
					<input type="text" name="dbsrvname" id="dbsrvname" value="localhost">
					<br />
					<label for="dbname">Nom de la base de données : </label>
					<input type="text" name="dbname" id="dbname" value="camagru">
					<br />
					<label for="dbusername">Nom d'utilisateur : </label>
					<input type="text" name="dbusername" id="dbusername" value="root">
					<br />
					<label for="dbpasswd">Mot de passe : </label>
					<input type="password" name="dbpasswd" id="dbpasswd" value="root">
					<br />
					<label for="dbport">Port : </label>
					<input type="text" name="dbport" id="dbport" value="3307">
				</fieldset>
				<input type="submit" name="submit" value="Suivant">
			</form>
		</div>
	</body>
</html>