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
				include("view/chat/connected.chat.view.php");
			} else {
				include("view/chat/disconnected.chat.view.php");
			}?>
	</body>
</html>