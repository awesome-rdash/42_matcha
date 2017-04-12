<?php
if (isUserLogged() && isset($currentUser)) {

?>
<p>Connecté en tant que <?php echo $currentUser->getNickname(); ?></p>

<?php include("view/header/notificationpage.header.view.php");?>

<p><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?action=logout" ; ?>"> Déconnexion</a></p>

<?php } ?>