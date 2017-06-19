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
		<style>
		fieldset {
			display: inline-block;
		}
		</style>
	</head>
	<body>
		<?php 
			include("view/header.view.php");
			?>
			<div id="filters">
			<form method="POST" action="recherche.php">
				<fieldset>
					<legend>Filtrer les profils</legend>
					<p>Un champs vide ou un 0 ne sera pas pris en compte dans la recherche</p>

					<fieldset>
						<legend>Par Age</legend>

						<label for="ageMin">Minimum</label>
						<input type="number" name="ageMin" id="ageMin" min="0" value="<?php echo $ageMin;?>"/>
						<br />

						<label for="ageMax">Maximum</label>
						<input type="number" name="ageMax" id="ageMax" min="0" value="<?php echo $ageMax;?>"/>
					</fieldset>

					<fieldset>
						<legend>Par score de popularite</legend>

						<label for="popMin">Minimum</label>
						<input type="number" name="popMin" id="popMin" min="0" value="<?php echo $popMin;?>"/>
						<br />

						<label for="popMax">Maximum</label>
						<input type="number" name="popMax" id="popMax" value="<?php echo $popMax;?>" />
					</fieldset>

					<fieldset>
						<legend>Par localisation</legend>

						<label for="localisation">Autour de...</label>
						<input type="text" name="localisation" id="localisation" value="<?php echo $localisation;?>"/>
						<br />
						
						<label for="locMax">Distance maximum</label>
						<input type="number" name="locMax" id="locMax" min="0" value="<?php echo $locMax;?>"/>
					</fieldset>

					<fieldset>
						<legend>Par centre d'interets</legend>

						<label for="tags">Listez les centres d'interet separes par une virgule</label>
						<input type="text" name="tags" id="tags" value="<?php echo $tags;?>"/>
					</fieldset>

					<fieldset>
						<legend>Par sexualite</legend>

						<label for="sexe">Sexe : </label>
						<input type="radio" name="sexe" value="male" <?php if ($sexe == "male") { echo "checked";}?>/>Homme - 
						<input type="radio" name="sexe" value="female"<?php if ($sexe == "female") { echo "checked";}?>/>Femme - 
						<input type="radio" name="sexe" value="both"<?php if ($sexe == "both") { echo "checked";}?>/>Les deux 
					</fieldset>

				</fieldset>

				<fieldset>
					<legend>Trier les profils</legend>
				   	<label for="sortMethod">Quelle methode voulez vous utiliser ?</label>
					<select name="sortMethod" id="sortMethod">
						<option value="age" <?php if ($sortMethod == "age") { echo "selected";}?>>Par age</option>
						<option value="popularity" <?php if ($sortMethod == "popularity") { echo "selected";}?>>Par score de popularite</option>
						<option value="localisation" <?php if ($sortMethod == "localisation") { echo "selected";}?>>Par localisation</option>
				        <option value="tags" <?php if ($sortMethod == "tags") { echo "selected";}?>>Par centre d'interets</option>
			        </select>
			        <br />

				   	<label for="sortOrder">Dans quelle ordre ?</label>
				   	<select name="sortOrder" id="sortOrder">
						<option value="desc" <?php if ($sortOrder == "desc") { echo "selected";}?>>Ordre decroissant</option>
						<option value="asc" <?php if ($sortOrder == "asc") { echo "selected";}?>>Ordre croissant</option>
			        </select>
				</fieldset>
				<input type="submit" value="Lancer la recherche" />
			</form>
		</div>
	</body>
</html>