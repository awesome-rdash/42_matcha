<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $pageTitle; ?></title>
		<meta charset="utf-8">
		<?php
			foreach($pageStylesheets as $cssPage) {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/" . $cssPage . "\">";
			}
		?>
	</head>
	<body>
		<?php 
			include("view/header.view.php");
			if (isUserLogged()) {
				include("view/index/connected.index.view.php");
			} else if (isset($custom_module) && $custom_module == "reset_password"){
				?>
				<form method="POST" action="index.php">
					<input type="hidden" name="action" value="useToken">
					<input type="hidden" name="token" value="<?php echo $token->getToken(); ?>">
					<label>Nouveau mot de passe : </label>
					<input type="password" name="newpassword">
					<input type="submit" value="Modifier le mot de passe">
				</form>
				<?php
			} else {
				include("view/index/non_connected.index.view.php");
			}
			?>
	</body>
</html>