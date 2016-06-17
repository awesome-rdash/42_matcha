<?php

$toCheck = array("nickname", "email", "password", "password2", "birthdate");

foreach($toCheck as $element)
if (!isset($_POST[$element]) || empty($_POST[$element])) {
	header("Location: register.php?error=" . $element);
}
echo "OK";