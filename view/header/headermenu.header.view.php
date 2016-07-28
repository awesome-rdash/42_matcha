<?php

$elementsList = array();
if (isUserLogged()) {
	$elementsList[] = array("Upload Picture", "camera.php");
	$elementsList[] = array("Gallery", "gallery.php");
} else {
	$elementsList[] = array("Gallery", "gallery.php");
}
echo "<ul>";

foreach($elementsList as $element) {
	echo "<li><a href=\"" . $element[1] . "\">" . $element[0] . "</a></li>\n";
}

echo "</ul>";