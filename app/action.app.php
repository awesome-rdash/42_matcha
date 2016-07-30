<?php

$valid_logged_actions = array(
	"logout",
	"useToken",
	"upload_file_image",
	"upload_camera_image",
	"comment_picture",
	"like_picture",
	"delete_picture",
	"upload_filter");

$valid_unlogged_actions = array(
	"register",
	"login",
	"useToken",
	"resetpassword");

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET;
} else if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST;
}

if (isset($action)) {
	if (isUserLogged()) {
		$valid_actions = $valid_logged_actions;
	} else {
		$valid_actions = $valid_unlogged_actions;
	}
	foreach($valid_actions as $va) {
		if ($action['action'] == $va) {
			require_once("app/actions/" . strtolower($action['action']) . ".action.php");
			$valid = true;
			if (isset($redirection)) {
				header("Location: " . basename($_SERVER['PHP_SELF']));
			}
		}
	}
} else {
	$valid = true;
}

if ($valid !== true) {
	header("Location: index.php");
}