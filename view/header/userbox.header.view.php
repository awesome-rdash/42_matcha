<?php
if (isUserLogged() && isset($currentUser)) {
?>
<p>Connecté en tant que <?php echo $currentUser->getNickname(); ?></p>
<p><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?action=logout" ; ?>"> Deconnexion</a></p>

<?php } ?>