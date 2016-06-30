<?php
$valid_actions = array(
	"register",
	"login",
	"logout",
	"useToken",
	"resetpassword");

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
	foreach($valid_actions as $va) {
		if ($action == $va) {
			require_once("app/actions/" . strtolower($action) . ".action.php");
			if (isset($redirection)) {
				header("Location: " . basename($_SERVER['PHP_SELF']));
			}
		}
	}
}