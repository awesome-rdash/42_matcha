<?php

include_once("app/init.app.php");

$pageTitle = "Chat";
$pageStylesheets = array ("main.css", "header.css");

/*
- Si chat avec personne, liste ecrite des pseudos avec qui il peut chat
- si chat avec une personne
-- si lid nexiste pas, redirection vers page sans chat

*/