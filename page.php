<?php
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
if($_GET['p']<0 || $_GET['p']>count($config['perso']))
	$_GET['p']=0;
$perso = new wms_perso($config,$_GET['p']);

?>
	<div id="banniere" style="background-image:url('<?php echo ($perso->g_faction()==0)?'img/profile_bg_alliance_full.jpg':'img/profile_bg_horde_full.jpg';?>');">
		<div id="portrait">
			<img src="<?php echo $perso->Draw_portrait();?>" style="float:left;position:relative;top:17px;left:22px;"/>
			<img src="img/lvlbg_<?php echo ($perso->g_faction()==0)?'alliance':'horde';?>.png" style="float:left;position:relative;top:66px;left:-29px;"/>
			<div style="float:left;position:relative;top:7px;left:0px;text-align:center;width:106px;"><?php echo $perso->g_lvl();?></div>
		</div>
		<div id="firstlni"><?php echo $perso->g_server().' ('.$perso->g_zone().')';?></div>
		<div id="firstln"><span><a href="<?php echo $perso->Draw_url();?>"><?php echo $perso->g_name();?></a></span>
		<?php if($perso->g_guild()!=''){echo ' <a href="'.$perso->Draw_guildurl().'">&lt;'.$perso->g_guild().'&gt;</a>';}?></div>
		<div id="secondlni"><?php echo $perso->g_vh().'vh&nbsp;&nbsp;&nbsp;<span><a href="'.$perso->Draw_activitifeed().'">'.$perso->g_hf().'</a></span>';?></div>
		<div id="secondln"><?php echo getclassname($perso->g_classe()).' '.getracename($perso->g_race()).' '.getsexename($perso->g_sexe())?><br />
		<sub><?php echo getthedate($perso->g_time()); ?></sub></div>
	</div>
	<?php //echo $perso->Draw_visu();?><br />
	<div style="float:right;text-align:right;">
		Métiers :<br />
		<table class="button"><tr>
			<td><img src="img/metier/<?php echo $perso->g_metier1('type');?>-sm.gif"/></td>
			<td>
			<?php echo getmetiername($perso->g_metier1('type'));?>
			<br /><?php echo $perso->g_metier1('value');?>/<?php echo $perso->g_metier1('max');?>
			</td>
		</tr></table>
		<table class="button"><tr>
			<td><img src="img/metier/<?php echo $perso->g_metier2('type');?>-sm.gif"/></td>
			<td>
			<?php echo getmetiername($perso->g_metier2('type'));?>
			<br /><?php echo $perso->g_metier2('value');?>/<?php echo $perso->g_metier2('max');?>
			</td>
		</tr></table>
	</div>
	
	Spécialisation :<br />
	<div id="spe">
	<?php
	echo '<table class="'.($perso->g_spe1(0)==0?'i':'').'button" onclick="changespe('.($perso->g_spe1(0)==0?'1':'0').');"><tr>
			<td>'.($perso->g_spe1(0)==1?'<img src="img/ok.png" alt="ok"/>':'').'</td>
			<td>'.getspename($perso->g_classe(),$perso->g_spe1(1),$perso->g_spe1(2),$perso->g_spe1(3)).'<br />
			'.$perso->g_spe1(1).'/'.$perso->g_spe1(2).'/'.$perso->g_spe1(3).'</td>
		</tr></table>';
	if($perso->g_hassecondspe())
	{
		echo '<table class="'.($perso->g_spe2(0)==0?'i':'').'button" onclick="changespe('.($perso->g_spe2(0)==0?'1':'0').');"><tr>
			<td>'.($perso->g_spe2(0)==1?'<img src="img/ok.png" alt="ok"/>':'').'</td>
			<td>'.getspename($perso->g_classe(),$perso->g_spe2(1),$perso->g_spe2(2),$perso->g_spe2(3)).'<br />
			'.$perso->g_spe2(1).'/'.$perso->g_spe2(2).'/'.$perso->g_spe2(3).'</td>
		</tr></table>';
	}
	?>
	</div>

<div class="separator" style="clear:right;"></div>

<?php

echo '<canvas id="historique" width="560" height="350" ></canvas>
<canvas id="stat" width="891" height="350" ></canvas>
';
?>
