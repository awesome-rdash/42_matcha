<?php

$member = new Member(0);
$return = $member->hydrate($_POST);

if ($return === true) {
	echo "LISE";
	$manager = new MemberManager($db);
	$return = $manager->newMemberFromRegistration($_POST);
}

if (is_object($return)) {
	$member = $return;

} else {
	$error = $return;
}