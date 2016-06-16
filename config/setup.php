<?php
session_start();

if ( isset($_GET['step']) )
{
	$step = $_GET['step'];
	if ( $step === 1 )
		include("config/setup/step1.php");
	else if ( $step === 2 )
		include("config/setup/step2.php");
	else if ( $step === 3 )
		include("config/setup/step3.php");
	else if ( $step === 4 )
		include("config/setup/step4.php");
}
else
	header("Location: setup.php?step=1");