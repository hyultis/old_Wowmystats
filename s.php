<?php
if(!isset($_GET['p']) && !isset($_GET['m']) && !isset($_GET['s']))
	header('Location: index.php');

//var def
if(!isset($config))
	$config = array();

// include
require_once('libs/config.inc.php');
require_once('libs/mysql.class.php');
require_once('libs/wow.class.php');

// get limit
if(!isset($_GET['p']))
	$_GET['p']=0;

$_GET['p'] = intval($_GET['p']);
if($_GET['p']<0 || $_GET['p']>count($config["perso"]))
	$_GET['p']=0;
$perso = new wms_perso($config,$_GET['p']);


$data = $perso->get_stats($_GET['m'],($_GET['s']==1)?true:false);
if(isset($data))
{
	for($t=0;$t<count($data);$t++)
	{
		for($a=0;$a<count($data[$t]);$a++)
		{
			if($a==0)
				echo $data[$t][$a];
			else
				echo ','.$data[$t][$a];
		}
		echo ';';
	}
}
else
	echo 'error';
?>
