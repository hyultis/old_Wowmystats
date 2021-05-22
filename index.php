<?php
//var def
$config = array();

// include
require_once('libs/config.inc.php');
require_once('libs/mysql.class.php');
require_once('libs/wow.class.php');

// get limit
if(!isset($_GET['p']))
	$_GET['p']=0;

$_GET['p'] = intval($_GET['p']);
if($_GET['p']<0 || $_GET['p']>count($config['perso']))
	$_GET['p']=0;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Wow my Stats !</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="css.css" />
		<script type="text/javascript" src="libs/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="libs/stats.js"></script>
		<script type="text/javascript" src="libs/js.js"></script>
	</head>
<body onload="setTimeout('main(<?php echo $_GET['p'];?>)',200)">
<div id="head"><a href="http://hyultis.monespace.net">WOW my stats !</a></div>
<div id="menu">
	<ul>
	<?php
	// menu
	for($t=0;$t<count($config["perso"]);$t++)
	{
		echo '<li'.(($t==$_GET['p'])?' class="activated"':'').'>
		<a href="index.php?p='.$t.'" onclick="changepage('.$t.');return false;">'.ucfirst($config['perso'][$t]['name']).'</a>
		</li>';
	}

	?>
	</ul>
</div>
<div id="body">
	<?php include('page.php'); ?>
</div>
<div id="foot"><img src="img/Blizzard.gif" alt="logo blizzard" style="float:right"/>Wow my stats crée par Brice JULLIAN n'est pas affilié à Blizzard, 
certaines images sont sous leurs droits d'auteurs, tout le reste est sous licence GPL, 
plus d'info sur le <a href="http://hyultis.monespace.net" style="color:#2465A6;">site officiel de Wow my stats !</a>
<div class="separator" style="clear:right;"></div></div>
</body>
</html>
