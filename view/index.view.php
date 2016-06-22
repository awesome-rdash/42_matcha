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
			if ($_SESSION['connected'] === true) {
				include("view/index/connected.index.view.php");
			} else {
				include("view/index/non_connected.index.view.php");
			}?>
	</body>
</html>