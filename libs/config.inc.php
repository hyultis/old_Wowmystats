<?php
/*------------------------------------------*\
|* type spe:                                *|
|* tank = tank                              *|
|* heal = soigneur                          *|
|* dps = cac + hunt                         *|
|* caster = lanceur de sort                 *|
|* pvp_x = version pvp (x = une autre spe)  *|
\*------------------------------------------*/

if(isset($config))
{
	$config['server'] = 'localhost';
	$config['login'] = 'test';
	$config['mdp'] = 'test';
	$config['database'] = 'wmsdpl';
	$config['prefix'] = 'wms_';
	$config['perso'][0] = array(
		'name' => 'peco',
		'server' => 'Culte de la rive noire',
		'zone' => 'EU',
		'spe1' => 'caster',
		'spe2' => 'heal'
	);
	$config['perso'][1] = array(
		'name' => 'hyultis',
		'server' => 'Culte de la rive noire',
		'zone' => 'EU',
		'spe1' => 'dps',
		'spe2' => 'tank'
	);
	/*$config['perso'][1] = array(
		'name' => 'ahyo',
		'server' => 'Culte de la rive noire',
		'zone' => 'EU',
		'spe1' => 'dps',
		'spe2' => 'tank'
	);
	$config['perso'][2] = array(
		'name' => 'Hya',
		'server' => 'Culte de la rive noire',
		'zone' => 'EU',
		'spe1' => 'caster',
		'spe2' => 'caster'
	);
	$config['perso'][3] = array(
		'name' => 'Bouheki',
		'server' => 'Culte de la rive noire',
		'zone' => 'EU',
		'spe1' => 'tank',
		'spe2' => 'heal'
	);*/
	$config['EU'] = 'eu.wowarmory.com';
	$config['US'] = 'www.wowarmory.com';
	$config['KR'] = 'kr.wowarmory.com';
	$config['CN'] = 'cn.wowarmory.com';
	$config['TW'] = 'tw.wowarmory.com';
}
else
	header('Location: index.php');

?>
