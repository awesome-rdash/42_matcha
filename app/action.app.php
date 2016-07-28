<?php
$valid_actions = array(
	"register",
	"login",
	"logout",
	"useToken",
	"resetpassword",
	"upload_file_image");

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET;
} else if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST;
}

if (isset($action)) {
	foreach($valid_actions as $va) {
		if ($action['action'] == $va) {
			require_once("app/actions/" . strtolower($action['action']) . ".action.php");
			if (isset($redirection)) {
				header("Location: " . basename($_SERVER['PHP_SELF']));
			}
		}
	}
}