<?php
session_start();

/*

MASTER PASSWORD
kef0x8160JV3|JQ

*/

function startsWith($haystack, $needle){
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function run_sql_file($location, $bdd, $dbname){
    $commands = file_get_contents($location);

    $lines = explode("\n",$commands);
    $commands = '';
    foreach($lines as $line){
        $line = trim($line);
        if ($line && !startsWith($line,'--')){
            $commands .= $line . "\n";
        }
    }

    $commands = explode(";", $commands);

    $total = $success = 0;

    $bdd->exec('USE ' . $dbname . ';');
    foreach($commands as $command){
        if(trim($command)){
            $success += ($bdd->exec($command)===false ? 0 : 1);
            $total += 1;
        }
    }
    return array(
        "success" => $success,
        "total" => $total
    );
}

function write_ini_file($assoc_arr, $path, $has_sections=FALSE) {
    $content = "";
    if ($has_sections) {
        foreach ($assoc_arr as $key=>$elem) {
            $content .= "[".$key."]\n";
            foreach ($elem as $key2=>$elem2) {
                if(is_array($elem2)) {
                    for($i=0;$i<count($elem2);$i++) {
                        $content .= $key2."[] = \"".$elem2[$i]."\"\n";
                    }
                }
                else if($elem2=="") $content .= $key2." = \n";
                else $content .= $key2." = \"".$elem2."\"\n";
            }
        }
    }
    else {
        foreach ($assoc_arr as $key=>$elem) {
            if(is_array($elem)) {
                for($i=0;$i<count($elem);$i++) {
                    $content .= $key."[] = \"".$elem[$i]."\"\n";
                }
            }
            else if($elem=="") $content .= $key." = \n";
            else $content .= $key." = \"".$elem."\"\n";
        }
    }
    if (!$handle = fopen($path, 'w')) {
        return false;
    }

    $success = fwrite($handle, $content);
    fclose($handle);

    return $success;
}

if ( isset($_GET['step']) )
{
	$step = $_GET['step'];
	if ( $step == 1 )
		include("setup/step1.php");
	else if ( $step == 2 )
		include("setup/step2.php");
	else if ( $step == 3 )
		include("setup/step3.php");
}
else {
        include("setup/step1.php");
}
