<div id="list">
<?php
$profilelikeManager = new ProfilelikeManager($db);
$listOfUsers = $profilelikeManager->getListOfMutualLikes($currentUser->getId());

echo "Voici la liste des utilisateurs avec qui vous pouvez chatter :<br />";
if (count($listOfUsers) == 0) {
	echo "Personne pour le moment, revenez plus tard. :(";
} else {
foreach($listOfUsers as $user)
	echo "<a href=\"chat.php?member=" . $user->getId() ."\">" . $user->getFirstName() . " " . $user->getLastName() . "</a><br />";
}
?>
</div>