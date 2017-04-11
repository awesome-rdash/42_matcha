<?php
if (isUserLogged() && isset($currentUser)) {

	$notificationManager = new NotificationManager($db);
	$unreadCount = $notificationManager->getUnreadNotificationsCount($currentUser->getId());
	$unreadNotifications = $notificationManager->getUnreadNotificationsToUser($currentUser->getId());
?>
<p>Connecté en tant que <?php echo $currentUser->getNickname(); ?></p>

<p>Notifications non lues : <?php echo $unreadCount; ?></p>

<p><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?action=logout" ; ?>"> Déconnexion</a></p>

<?php } ?>