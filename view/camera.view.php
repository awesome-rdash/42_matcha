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
			if (isUserLogged()) {
				include("view/camera/connected.camera.view.php");
			} else {
				include("view/camera/disconnected.camera.view.php");
			}?>
	</body>
</html>