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
		<div id="filters">
			<form method="POST" action="gallery.php">
				<label for="uid">Images venant de l'utilisateur : </label>
				<select name="uid">
					<option value="0" <?php if ($uid == 0) {echo "selected";} ?>>Tous les utilisateurs</option>
					<?php
						$member = new Member(0);
						foreach($usersList as $element) {
							$member->hydrate($element);
							$selected = "";
							if ($uid == $member->getId()) {
								$selected = "selected";
							}
							echo "<option value=\"" . $member->getId() . "\" " . $selected . ">" . $member->getNickname() . "</option>";
						}
					?>
				</select>
				<label for="ppp">Nombre d'images par page : </label>
				<select name="ppp">
					<option value="10" <?php if ($ppp == "10") {echo "selected";} ?>>10</option>
					<option value="25" <?php if ($ppp == "25") {echo "selected";} ?>>25</option>
					<option value="50" <?php if ($ppp == "50") {echo "selected";} ?>>50</option>
					<option value="100" <?php if ($ppp == "100") {echo "selected";} ?>>100</option>
				</select>
				<label for="ppp">Ordre de tri des images : </label>
				<select name="order">
					<option value="desc" <?php if ($order == "DESC") {echo "selected";} ?>>Du plus recent au plus ancien</option>
					<option value="asc" <?php if ($order == "ASC") {echo "selected";} ?>>Du plus ancien au plus recent</option>
				</select>
				<input type="submit" value="Filtrer les images">
			</form>
		</div>
		<div id="page_selector">
			<p>PAGE : <?php
			for ($i = 0; $i <= $nbPages; $i++) {
				$current = "";
				if ($i == $page) {
					$current = "class=\"currentPage\"";
				}
				echo "<a $current href=\"gallery.php?page=$i\">$i</a>";
				if ($i < $nbPages) {
					echo " - ";
				}
			}
			?></p>
		</div>
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