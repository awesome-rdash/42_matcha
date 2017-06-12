<?php

$elementsList = array();
if (isUserLogged()) {
	$elementsList[] = array("Envoyer un montage", "camera.php");
	$elementsList[] = array("Galerie", "gallery.php");
	$elementsList[] = array("Chat", "chat.php");
	$elementsList[] = array("Mon profil", "profile.php");
} else {
	$elementsList[] = array("Galerie", "gallery.php");
}
echo "<ul>";

foreach($elementsList as $element) {
	echo "<li><a href=\"" . $element[1] . "\">" . $element[0] . "</a></li>\n";
}

echo "</ul>";