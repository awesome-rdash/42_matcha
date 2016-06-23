<?php
$valid_actions = array(
	"register",
	"login",
	"logout"
	"useToken");

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
	foreach($valid_actions as $va) {
		if ($action == $va) {
			require_once("app/actions/" . tolower($action) . ".action.php");
			if (isset($redirection)) {
				header("Location: " . basename($_SERVER['PHP_SELF']));
			}
		}
	}
}