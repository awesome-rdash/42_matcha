<?php
if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
	header("Location: setup.php");
}

$error = 0;
if (isset($_POST['submit'])) {
	if (isset($_POST['dbsrvname']) && isset($_POST['dbusername']) && isset($_POST['dbpasswd']) && isset($_POST['dbport']) && isset($_POST['dbname'])) {
		if ($_POST['dbsrvname'] !== "" && $_POST['dbname'] !== "" && $_POST['dbusername'] !== "" && $_POST['dbport'] !== "") {
			try {
				if (!ctype_alnum($_POST['dbname'])) {
					throw new Exception("Le nom de la base de données ne peut contenir que des caractères alphanumériques.");
				}
				if (isset($_POST['createdb']) && $_POST['createdb'] === "createdb") {
					$db = "";
				} else {
					$db = ";dbname=" . htmlspecialchars($_POST['dbname']);
				}
				$bdd = new PDO('mysql:host=' . htmlspecialchars($_POST['dbsrvname']) .
					';port=' . htmlspecialchars($_POST['dbport']) .
					$db .
					';charset=utf8',
					htmlspecialchars($_POST['dbusername']),
					$_POST['dbpasswd']);
				if (empty($db)) {
					$q = $bdd->exec('CREATE DATABASE IF NOT EXISTS ' . $_POST['dbname'] . ' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;');
				}
				$tosave = array(
					'db_host' => htmlspecialchars($_POST['dbsrvname']),
					'db_username' => htmlspecialchars($_POST['dbusername']),
					'db_passwd' => $_POST['dbpasswd'],
					'db_name' => htmlspecialchars($_POST['dbname']),
					'db_port' => htmlspecialchars($_POST['dbport']));
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
		<?php if ($error) { echo "<p><font color=\"red\">Erreur : Connexion impossible à la base de données. Veuillez vérifier vos informations.<br /></font></p>"; } ?>
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
					<label for="createdb">Créer la base de donnée si elle n'existe pas (recommandé)</label>
					<input type="checkbox" name="createdb" value="createdb" checked>
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
				<input type="submit" name="submit" value="REINSTALLER L'APPLICATION. ACTION IRREVERSIBLE !">
			</form>
		</div>
	</body>
</html>