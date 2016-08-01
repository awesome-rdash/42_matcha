<?php
if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
	header("Location: setup.php");
}

$error = 0;
if (file_exists("cfg.ini")) {
	$db_infos = parse_ini_file("cfg.ini");
	try {
		include "database.php";
		$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ERRMODE_EXCEPTION));
		if (file_exists("database.sql")) {
			$req = run_sql_file("database.sql", $bdd, $db_infos['db_name']);
		} else {
			$error = 1;
		}
	} catch (Exception $e) {
		$error = 1;
	}
} else {
	header("Location: setup.php?step=2");
}
?>

<html>
	<head>
		<title>DANGER ZONE</title>
		<meta charset="utf-8">
	</head>
	<body>
		<div id="page">
			<h1>Configuration terminée</h1>
			<?php if (($req['total'] - $req['success']) !== 0) { ?> 
				<p>ATTENTION : la base de données n'a pas pu être totalement mise en place. <br /> <strong><?php echo ($req['total'] - $req['success']); ?></strong> instructions (sur <?php echo $req['total']; ?>) n'ont pas été correctement exécutée(s).</p>
				<p><a href="setup.php?step=2"> Retour en arrière</a></p>
				<p><a href="../index.php"> Accéder au site</a></p>
				<?php } else { ?>
				<p>Votre site est maintenant prêt à l'emploi !</p>
				<p>Utilisez les identifiants admin - kef0x8160JV3|JQ pour vous connecter pour la première fois.</p>
				<p><a href="../index.php"> Accéder au site</a></p>
			<?php } ?>
		</div>
	</body>
</html>