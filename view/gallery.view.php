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
		$picManager = new UserPictureManager($db);
		$pics = $picManager->getEditedPictures();
		foreach($pics as $element) {
			$pic = new UserPicture(0);
			$pic->hydrate($element);
			?>
			<div class="picture">
				<img src="data/userpics/<?php echo $pic->getId();?>.jpeg" class="userpic" />
			</div>
			<?php
		}
		?>
		</div>
	</body>
</html>