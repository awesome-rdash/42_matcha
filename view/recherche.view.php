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
			<form method="POST" action="recherche.php">
				<label for="age">Tranche d'age : </label>
				<select name="uid">
					<option value="0" <?php if ($age == 0) {echo "selected";} ?>>Tous les ages</option>
					<option value="1" <?php if ($age == 1) {echo "selected";} ?>>Moins de 18 ans</option>
					<option value="2" <?php if ($age == 2) {echo "selected";} ?>>Entre 18 et 21 ans</option>
					<option value="3" <?php if ($age == 3) {echo "selected";} ?>>Entre 21 et 27 ans</option>
					<option value="4" <?php if ($age == 4) {echo "selected";} ?>>Entre 27 et 35 ans</option>
					<option value="5" <?php if ($age == 5) {echo "selected";} ?>>Entre 35 et 45 ans</option>
					<option value="6" <?php if ($age == 6) {echo "selected";} ?>>Entre 45 et 60 ans</option>
					<option value="7" <?php if ($age == 7) {echo "selected";} ?>>Entre 60 et 80 ans</option>
					<option value="8" <?php if ($age == 8) {echo "selected";} ?>>Plus de 80 ans</option>
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
	</body>
</html>