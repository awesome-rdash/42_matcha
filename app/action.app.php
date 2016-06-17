<?php
$valid_actions = array("register");

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
	foreach($valid_actions as $va) {
		if ($action = $va) {
			require_once("app/actions/" . $action . ".action.php");
		}
	}
}