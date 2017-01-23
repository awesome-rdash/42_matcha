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
		<script src="assets/js/awesomplete.js" async></script>
	</head>
	<body>
		<?php
			include("view/header.view.php");
			if (isUserLogged()) {
				include("view/profile/connected.profile.view.php");
			} else {
				include("view/profile/disconnected.profile.view.php");
			}?>
	</body>
</html>