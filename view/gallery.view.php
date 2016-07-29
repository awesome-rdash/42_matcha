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
		?>
		<div id="pics_page">
		<?php
		foreach($pics as $element) {
			$pic = new UserPicture(0);
			$pic->hydrate($element);
			?>
			<div class="picture">
				<a href="picture.php?pic=<?php echo $pic->getId(); ?>"><img src="data/userpics/<?php echo $pic->getId();?>.jpeg" class="userpic" /></a>
			</div>
			<?php
		}
		?>
		</div>
	</body>
</html>