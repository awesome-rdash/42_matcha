<?php

if (isset($_POST['data']) && !empty($_POST['data'])) {
	$data = json_decode($_POST['data']);
} else {
	$error = "no_data";
}