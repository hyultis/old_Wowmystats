<?php
//var def
if(!isset($config))
	$config = array();

// include
require_once("libs/config.inc.php");
require_once("libs/mysql.inc.php");
require_once("libs/wow.inc.php");

for($t=0;$t<count($config["perso"]);$t++)	
	$perso = new wms_perso($config,$t);
	
header("Location: index.php");

?>
