<?php
require_once('ll.class.php');
require_once('xml.class.php');
global $ll;
$ll = new hfw_ll('en','libs/loc/',true);

/*------------------------*\
|* type :                 *|
|* 0 = tank               *|
|* 1 = heal               *|
|* 2 = dps cac + hunt     *|
|* 3 = dps caster         *|
|* 4 = pvp                *|
\*------------------------*/

/*---------------------------*\
|* classe :                  *|
|* 1 = guerrier              *|
|* 2 = paladin               *|
|* 3 = chasseur              *|
|* 4 = voleur                *|
|* 5 = pretre                *|
|* 6 = chevalier de la mort  *|
|* 7 = chaman                *|
|* 8 = mage                  *|
|* 9 = demoniste             *|
|* 10 =                      *|
|* 11 = druide               *|
\*---------------------------*/

/*-----------------------*\
|* race :                *|
|* 1 = humain            *|
|* 2 = orc               *|
|* 3 = nain              *|
|* 4 = elfe de la nuit   *|
|* 5 = mort vivant       *|
|* 6 = tauren            *|
|* 7 = gnome             *|
|* 8 = troll             *|
|* 9 =                   *|
|* 10 = elfe de sang     *|
|* 11 = draenie          *|
\*-----------------------*/

class wms_perso
{
	private $name = '';
	private $server = '';
	private $zone = '';
	private $lvl = 0;
	private $classe = 0;
	private $faction = 0;
	private $race = 0;
	private $sexe = 0;
	private $hf = 0;
	private $vh = 0;
	private $guild = '';
	private $ilvl = 0;
	private $hassecondspe = false;
	private $speactive = 1;
	private $spepossible1 = 1;
	private $spepossible2 = 1;
	private $spe1 = array();
	private $spe2 = array();
	private $metier1 = array('id' => 0,'value' => 0,'max' => 0);
	private $metier2 = array('id' => 0,'value' => 0,'max' => 0);
	private $xml = null;
	private $config = null;
	private $mysql = null;
	private $personum = 0;
	private $spedata = array();
	private $time = 0;
	private $nbhistorique = 0;

	function __construct($config,$personum)
	{
		$this->time = 0;
		
		$this->personum = $personum;
		$this->config = $config;
		$this->name = $config['perso'][($personum)]['name'];
		$this->server_url = str_replace(' ','+',$config['perso'][($personum)]['server']);
		$this->server = $config['perso'][($personum)]['server'];
		$this->zone = $config['perso'][($personum)]['zone'];
		$this->spepossible1 = $this->config['perso'][($this->personum)]['spe1'];
		$this->spepossible2 = $this->config['perso'][($this->personum)]['spe2'];
		$this->mysql = new hfw_mysql($this->config);
		
		// si pas a jour
		$this->get_last_data_time();
		$this->get_data_xml();		
		if($this->time+(3600*6) < time())
			$this->get_data_xml();
		else
			$this->get_data_sql();	
	}
	
	private function get_data_xml()
	{
		// obtention des donnée xml
		$this->xml = $this->get_perso_xml();
		
		if(isset($this->xml))
		{

			$timeofxml = $this->xml->characterInfo->character->attributes()->lastModified;
			if(strtotime($timeofxml) > $this->time)
			{
				// récuperation des donnée du xml
				$this->lvl = $this->xml->characterInfo->character->attributes()->level + 0;
				$this->classe = $this->xml->characterInfo->character->attributes()->classId + 0;
				$this->race = $this->xml->characterInfo->character->attributes()->raceId + 0;
				$this->sexe = $this->xml->characterInfo->character->attributes()->genderId + 0;
				$this->faction = $this->xml->characterInfo->character->attributes()->factionId + 0;
				$this->hf = $this->xml->characterInfo->character->attributes()->points + 0;
				$this->guild = $this->xml->characterInfo->character->attributes()->guildName;
				$this->vh = $this->xml->characterInfo->characterTab->pvp->lifetimehonorablekills[0]->attributes()->value + 0;
				$this->metier1['type'] = $this->xml->characterInfo->characterTab->professions->skill[0]->attributes()->key;
				$this->metier1['value'] = $this->xml->characterInfo->characterTab->professions->skill[0]->attributes()->value + 0;
				$this->metier1['max'] = $this->xml->characterInfo->characterTab->professions->skill[0]->attributes()->max + 0;
				$this->metier2['type'] = $this->xml->characterInfo->characterTab->professions->skill[1]->attributes()->key;
				$this->metier2['value'] = $this->xml->characterInfo->characterTab->professions->skill[1]->attributes()->value + 0;
				$this->metier2['max'] = $this->xml->characterInfo->characterTab->professions->skill[1]->attributes()->max + 0;
				
				// stuff
				$items = $this->xml->characterInfo->characterTab->items->item;
				for($t=0;$t<count($items);$t++)
				{
					$this->ilvl = $this->ilvl + ($items[$t]->attributes()->level + 0);
				}
				$this->ilvl = floor($this->ilvl / count($items));
				
				// spe
				$this->hassecondspe = (count($this->xml->characterInfo->characterTab->talentSpecs->talentSpec)>1)?true:false;
				$this->spe1[0] = $this->xml->characterInfo->characterTab->talentSpecs->talentSpec[0]->attributes()->active + 0;
				$this->spe1[1] = $this->xml->characterInfo->characterTab->talentSpecs->talentSpec[0]->attributes()->treeOne + 0;
				$this->spe1[2] = $this->xml->characterInfo->characterTab->talentSpecs->talentSpec[0]->attributes()->treeTwo + 0;
				$this->spe1[3] = $this->xml->characterInfo->characterTab->talentSpecs->talentSpec[0]->attributes()->treeThree + 0;
				$this->speactive = $this->config['perso'][($this->personum)]['spe1'];
				if($this->hassecondspe)
				{
					$this->spe2[0] = $this->xml->characterInfo->characterTab->talentSpecs->talentSpec[1]->attributes()->active + 0;
					$this->spe2[1] = $this->xml->characterInfo->characterTab->talentSpecs->talentSpec[1]->attributes()->treeOne + 0;
					$this->spe2[2] = $this->xml->characterInfo->characterTab->talentSpecs->talentSpec[1]->attributes()->treeTwo + 0;
					$this->spe2[3] = $this->xml->characterInfo->characterTab->talentSpecs->talentSpec[1]->attributes()->treeThree + 0;
				}
			
				//spe post traitement
				if($this->xml->characterInfo->characterTab->talentSpecs->talentSpec[0]->attributes()->group == 2)
				{
					$temp = $this->spe1;
					$this->spe1 = $this->spe2;
					$this->spe2= $temp;
				}
				if($this->spe2[0]==1 && $this->hassecondspe)
						$this->speactive = $this->config['perso'][($this->personum)]['spe2'];
			
				//metier post-traitement
				if ($this->metier1['value'] > $this->metier1['max'])
					$this->metier1['max'] = $this->metier1['value'];
				if ($this->metier2['value'] > $this->metier2['max'])
					$this->metier2['max'] = $this->metier2['value'];
				
				if($this->speactive == 'tank')
				{
					$this->spedata['vie'] = $this->xml->characterInfo->characterTab->characterBars->health->attributes()->effective;
					$this->spedata['endu'] = $this->xml->characterInfo->characterTab->baseStats->strength->attributes()->effective;
					$this->spedata['esquive'] = $this->xml->characterInfo->characterTab->defenses->dodge->attributes()->rating;
					$this->spedata['parade'] = $this->xml->characterInfo->characterTab->defenses->parry->attributes()->rating;
					$this->spedata['blocage'] = $this->xml->characterInfo->characterTab->defenses->block->attributes()->rating;
					$this->spedata['defence'] = $this->xml->characterInfo->characterTab->defenses->defense->attributes()->plusDefense + $this->xml->characterInfo->characterTab->defenses->defense->attributes()->value;
					$this->spedata['armure'] = $this->xml->characterInfo->characterTab->defenses->armor->attributes()->effective;
					$this->spedata['pa'] = $this->xml->characterInfo->characterTab->melee->power->attributes()->effective;
					$this->spedata['toucher'] = $this->xml->characterInfo->characterTab->melee->hitRating->attributes()->value;
					$this->spedata['expertise'] = $this->xml->characterInfo->characterTab->melee->expertise->attributes()->value;
				}
				else if($this->speactive == 'heal')
				{
					$this->spedata['mana'] = $this->xml->characterInfo->characterTab->characterBars->secondBar->attributes()->effective;
					$this->spedata['hate'] = $this->xml->characterInfo->characterTab->spell->hasteRating->attributes()->hasteRating;
					$this->spedata['cc'] = $this->xml->characterInfo->characterTab->spell->critChance->attributes()->rating;
					$this->spedata['bonsoin'] = $this->xml->characterInfo->characterTab->spell->bonusHealing->attributes()->value;
					$this->spedata['mp5'] = $this->xml->characterInfo->characterTab->spell->manaRegen->attributes()->casting;
					$this->spedata['intel'] = $this->xml->characterInfo->characterTab->baseStats->intellect->attributes()->effective;
					$this->spedata['esprit'] = $this->xml->characterInfo->characterTab->baseStats->spirit->attributes()->effective;
				}
				else if($this->speactive == 'dps')
				{
					$this->spedata['vie'] = $this->xml->characterInfo->characterTab->characterBars->health->attributes()->effective;
					$this->spedata['dpscac'] = ($this->xml->characterInfo->characterTab->melee->mainHandDamage->attributes()->max + $this->xml->characterInfo->characterTab->melee->mainHandDamage->attributes()->min)/2 + 
								($this->xml->characterInfo->characterTab->melee->offHandDamage->attributes()->max + $this->xml->characterInfo->characterTab->melee->offHandDamage->attributes()->min)/2;
					$this->spedata['dpsdistant'] = $this->xml->characterInfo->characterTab->ranged->damage->attributes()->dps;
					$this->spedata['hate'] = $this->xml->characterInfo->characterTab->melee->mainHandSpeed->attributes()->hasteRating;
					$this->spedata['cc'] = $this->xml->characterInfo->characterTab->melee->critChance->attributes()->rating;
					$this->spedata['pa'] = $this->xml->characterInfo->characterTab->melee->power->attributes()->effective;
					$this->spedata['toucher'] = $this->xml->characterInfo->characterTab->melee->hitRating->attributes()->value;
					$this->spedata['parmure'] = $this->xml->characterInfo->characterTab->melee->hitRating->attributes()->penetration;
					$this->spedata['expertise'] = $this->xml->characterInfo->characterTab->melee->expertise->attributes()->value;
				}
				else if($this->speactive == 'caster')
				{
					$this->spedata['mana'] = $this->xml->characterInfo->characterTab->characterBars->secondBar->attributes()->effective;
					$this->spedata['hate'] = $this->xml->characterInfo->characterTab->spell->hasteRating->attributes()->hasteRating;
					$this->spedata['cc'] = $this->xml->characterInfo->characterTab->spell->critChance->attributes()->rating;
					$this->spedata['sp'] = $this->xml->characterInfo->characterTab->spell->bonusDamage->arcane->attributes()->value;
					$this->spedata['toucher'] = $this->xml->characterInfo->characterTab->spell->hitRating->attributes()->value;
					$this->spedata['intel'] = $this->xml->characterInfo->characterTab->baseStats->intellect->attributes()->effective;
					$this->spedata['esprit'] = $this->xml->characterInfo->characterTab->baseStats->spirit->attributes()->effective;
				}
			
				$this->insert_data();

			}
		}
		$this->get_data_sql();	
	}
	
	private function get_data_sql()
	{
		$this->mysql = new hfw_mysql($this->config);
		$result = $this->mysql->query('SELECT * FROM '.$this->mysql->prefix().'perso WHERE srv='.$this->g_server_id().' AND nom="'.$this->mysql->protec($this->name).'" AND date='.$this->time);
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			$this->classe = $row['classe'];
			$this->race = $row['race'];
			$this->sexe = $row['sexe'];
			$this->metier1['type'] = $row['metier1'];
			$this->metier1['max'] = $row['metier1max'];
			$this->metier1['value'] = $row['metier1value'];
			$this->metier2['type'] = $row['metier2'];
			$this->metier2['max'] = $row['metier2max'];
			$this->metier2['value'] = $row['metier2value'];
			$this->faction = $row['faction'];
			$this->lvl = $row['niveau'];
			$this->hf = $row['hf'];
			$this->vh = $row['vh'];
			$this->ilvl = $row['ilvl'];
			$this->guild = $this->g_guild_name($row['guild']);
			$this->speactive = $row['spetype'];
			$this->spe1 = explode('/',$row['spe1']);
			if($row['spe2']!='')
			{
				$this->spe2 = explode('/',$row['spe2']);
				$this->hassecondspe = true;
			}
			
			$speid = $row['speid'];
			
			$result = $this->mysql->query('SELECT * FROM '.$this->mysql->prefix().$this->speactive.' WHERE id='.$speid);
			$tab = array();
			$row = mysql_fetch_array($result);
			
			foreach ($row as $key => $value)
			{
				if(!is_numeric($key) && $key!='id')
					$this->spedata[$key] = $value;
			}
		}
		return;
	}
	
	private function get_last_data_time()
	{
		
		if($this->g_server_id() == -1 || $this->name=='')
		{
			$this->time = 0;
		}
		else
		{
			$result = $this->mysql->query('SELECT * FROM '.$this->mysql->prefix().'perso WHERE srv='.$this->g_server_id().' AND nom="'.$this->mysql->protec($this->name).'" ORDER BY date DESC LIMIT 0,1');
			if(mysql_num_rows($result)>0)
			{
				$row = mysql_fetch_array($result);
				$this->time = $row['date'];
			}
		}
	}
	
	public function get_stats($mode=0,$secondspe=false)
	{
		global $ll;
		$tab = null;
		if($mode==15)
		{
			$tab = array();
			
			// select spe
			$selectedspetodraw = $this->speactive;
			if($secondspe && $this->hassecondspe)
			{
				if($this->speactive == $this->spepossible1)
					$selectedspetodraw = $this->spepossible2;
				else
					$selectedspetodraw = $this->spepossible1;
			}
			
			$result = $this->mysql->query('SELECT * FROM '.$this->mysql->prefix().$selectedspetodraw.','.$this->mysql->prefix().'perso WHERE '.$this->mysql->prefix().'perso.speid='.
			$this->mysql->prefix().$selectedspetodraw.'.id AND spetype="'.$selectedspetodraw.'" AND srv='.$this->g_server_id().' AND nom="'.$this->mysql->protec($this->name).
			'" ORDER BY date DESC');
			
			while(($row = mysql_fetch_array($result))==true)
			{
				$tabsql[] = $row;
			}
			
			// obtention du nom des colonnes
			$rowname = array();
			$rowname[] = 'date';
			foreach($tabsql[0] as $key => $value)
			{
				if($key!='id' && $key!='nom' && $key!='srv' && $key!='date' && $key!='race' && $key!='classe' && $key!='sexe' 
				&& $key!='metier1' && $key!='metier1max' && $key!='metier1value' && $key!='metier2' && $key!='metier2max' && $key!='metier2value'
				&& $key!='faction' && $key!='hf' && $key!='vh' && $key!='guild' && $key!='spe1' && $key!='spe2' && $key!='spetype' && $key!='speid'
				&& !is_numeric($key))
					$rowname[] = $key;
			}
			
			/*echo '<pre>';
			print_r($rowname);
			die();*/
			
			// nos des données
			$pretab = array();
			for($x=0;$x<count($rowname);$x++)
			{
				$pretab[] = $ll->str('stat_'.$rowname[$x]);
			}
			$tab[] = $pretab;
			
			for($t=0;$t<count($tabsql);$t++)
			{
				$pretab = array();
				for($x=0;$x<count($rowname);$x++)
				{
					if($rowname[$x]=='date')
						$pretab[] = $tabsql[$t][($rowname[$x])].'000';
					else
						$pretab[] = $tabsql[$t][($rowname[$x])];
				}
				
				$tab[] = $pretab;
			}
			
		}
		else // historique
		{
			$tab = array();
			$tabsql = array();
			$result = $this->mysql->query('SELECT * FROM '.$this->mysql->prefix().'perso WHERE srv='.$this->g_server_id().' AND nom="'.$this->mysql->protec($this->name).'" ORDER BY date DESC');
			while(($row = mysql_fetch_array($result))==true)
			{
				$tabsql[] = $row;
			}
			
			// duplicate the last
			$tabsql[] = $tabsql[(count($tabsql)-1)];
			
			// stats
			// server change
			// guilde change
			// spe change (spe change , spetype non)
			// respe (spetype change)
			// metier change
			// metier up
			// faction change
			// race change
			
			$tab[] = array('date',
			$ll->str('stat_guild'),
			$ll->str('stat_persoepic'),
			$ll->str('stat_lvl'),
			$ll->str('stat_spe'),
			$ll->str('stat_spetype'),
			$ll->str('stat_metier1'),
			$ll->str('stat_metier1max'),
			$ll->str('stat_metier2'),
			$ll->str('stat_metier2max'),
			$ll->str('stat_spesecondaire')
			);
			
			for($t=0;$t<count($tabsql)-1;$t++)
			{
				// spe
				$spe = explode('/',$tabsql[$t]['spe1']);
				$spe = ($spe[0]==0)?1:0;
					
				$spetypechange = 0;
				if($spe==0)
				{
					if($this->spepossible1 != $tabsql[$t]['spetype'])
					{
						$spetypechange = 1;
						$this->spepossible1 = $tabsql[$t]['spetype'];
					}
				}
				else
				{
					if($this->spepossible2 != $tabsql[$t]['spetype'])
					{
						$spetypechange = 1;
						$this->spepossible2 = $tabsql[$t]['spetype'];
					}
				}

				
				// respe
				$respe = 0;
				if($spetypechange==0)
				{
					// on cherche la dernier enregistrement de la meme spe
					$lastsamespe = -1;
					for($a=0;$a<$t;$a++)
					{
						$findspe = explode('/',$tabsql[$a]['spe1']);
						$findspe = ($findspe[0]==0)?1:0;
						if($spe == $findspe)
						{
							$lastsamespe = $a;
						}
					}
				
					if($lastsamespe>-1 && $t<count($tabsql)-2)
					{
					if($spe==0 && $tabsql[$t]['spe1']!=$tabsql[$lastsamespe]['spe1'])
						$respe = 1;
					else if($spe==1 && $tabsql[$t]['spe2']!=$tabsql[$lastsamespe]['spe2'])
						$respe = 1;
					}
				}
			
				$tab[] = array($tabsql[$t]['date'].'000',
				($tabsql[$t]['guild']!=$tabsql[($t+1)]['guild'])?1:0,
				($tabsql[$t]['race']!=$tabsql[($t+1)]['race'] || $tabsql[$t]['sexe']!=$tabsql[($t+1)]['sexe'] || $tabsql[$t]['faction']!=$tabsql[($t+1)]['faction'])?1:0,
				($tabsql[$t]['niveau']>$tabsql[($t+1)]['niveau'])?1:0,
				($tabsql[$t]['niveau']>$tabsql[($t+1)]['niveau'])?0:$respe,
				$spetypechange,
				($tabsql[$t]['metier1']!=$tabsql[($t+1)]['metier1'])?1:0,
				($tabsql[$t]['metier1max']>$tabsql[($t+1)]['metier1max'])?1:0,
				($tabsql[$t]['metier2']!=$tabsql[($t+1)]['metier2'])?1:0,
				($tabsql[$t]['metier2max']>$tabsql[($t+1)]['metier2max'])?1:0,
				$spe);
			}
		}
		
		return $tab;
	}

	
	private function insert_data()
	{
		// insert toute les donnée de la classe dans la base de donnée
		$guildid = -1;
		$speid = -1;
		
		// serveur
		$serverid = $this->g_server_id();
		if($serverid==-1)
		{
			$this->mysql->query('INSERT INTO '.$this->mysql->prefix().'srv VALUES("","'.$this->mysql->protec($this->zone).'","'.$this->mysql->protec($this->server).'")');
			$serverid = mysql_insert_id();
		}
		
		// guilde
		if($this->guild != '')
		{
			$result = $this->mysql->query('SELECT id FROM '.$this->mysql->prefix().'guild WHERE server="'.$this->mysql->protec($this->server).'" AND name="'.$this->mysql->protec($this->guild).'"');
			if(mysql_num_rows($result)>0)
			{
				$row = mysql_fetch_array($result);
				$guildid = $row['id'];
			}
			else
			{
				$this->mysql->query('INSERT INTO '.$this->mysql->prefix().'guild VALUES("","'.$this->mysql->protec($this->server).'","'.$this->mysql->protec($this->guild).'")');
				$guildid = mysql_insert_id();
			}
		}
		
		// spe
		if($this->speactive == 'tank' || $this->speactive == 'heal' || $this->speactive == 'dps' || $this->speactive == 'caster')
		$rk = '';
		$rv = '';
		foreach ($this->spedata as $key => $value)
		{
			$rk .= ','.$key.'';
			$rv .= ','.$value;
		}
		//$requete .= '"'.$this->mysql->protec($this->server).'",';
		$requete = 'INSERT INTO '.$this->mysql->prefix().$this->speactive.' (id'.$rk.') VALUES(null'.$rv.')';
		$this->mysql->query($requete);
		$speid = mysql_insert_id();
		
		
		// perso
		$spe1 = $this->spe1[0].'/'.$this->spe1[1].'/'.$this->spe1[2].'/'.$this->spe1[3];
		$spe2 = '';
		if ($this->hassecondspe)
			$spe2 = $this->spe2[0].'/'.$this->spe2[1].'/'.$this->spe2[2].'/'.$this->spe2[3];
		
		$this->mysql->query('INSERT INTO '.$this->mysql->prefix().'perso VALUES('.time().',"'.$this->mysql->protec($this->name).'","'.$serverid.'",
		"'.$this->race.'",
		"'.$this->classe.'",
		"'.$this->sexe.'",
		"'.$this->mysql->protec($this->metier1['type']).'",
		"'.$this->metier1['max'].'",
		"'.$this->metier1['value'].'",
		"'.$this->mysql->protec($this->metier2['type']).'",
		"'.$this->metier2['max'].'",
		"'.$this->metier2['value'].'",
		"'.$this->faction.'",
		"'.$this->lvl.'",
		"'.$this->hf.'",
		"'.$this->vh.'",
		"'.$this->ilvl.'",
		"'.$guildid.'",
		"'.$spe1.'",
		"'.$spe2.'",
		"'.$this->mysql->protec($this->speactive).'",
		 '.$speid.')');
		
		
		return;
	}
	
	public function g_server_id()
	{
		$result = $this->mysql->query('SELECT id FROM '.$this->mysql->prefix().'srv WHERE name="'.$this->mysql->protec($this->server).'"');
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			return $row['id'];
		}
		
		return -1;
	}
	
	public function g_server_name($id)
	{
		$result = $this->mysql->query('SELECT name FROM '.$this->mysql->prefix().'srv WHERE id="'.$id.'"');
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			return $row['name'];
		}
		
		return '';
	}
	
	public function g_guild_id()
	{
		$result = $this->mysql->query('SELECT id FROM '.$this->mysql->prefix().'guild WHERE srv="'.$this->mysql->protec($this->server).'" AND name="'.$this->mysql->protec($this->guild).'"');
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			return $row['id'];
		}
		
		return -1;
	}
	
	public function g_guild_name($id)
	{
		$result = $this->mysql->query('SELECT name FROM '.$this->mysql->prefix().'guild WHERE id="'.$id.'"');
		if(mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			return $row['name'];
		}
		
		return '';
	}
	
	/*---------------------- GUILD ------------------*/
	
	public function set_guild($name)
	{
		
	}
	
	/*------------------- GET -------------------*/
	
	public function g_name() {return ucfirst($this->name);}
	public function g_server() {return $this->server;}
	public function g_server_url() {return $this->server_url;}
	public function g_zone() {return $this->zone;}
	public function g_lvl() {return $this->lvl;}
	public function g_classe() {return $this->classe;}
	public function g_race() {return $this->race;}
	public function g_sexe() {return $this->sexe;}
	public function g_faction() {return $this->faction;}
	public function g_guild() {return $this->guild;}
	public function g_hassecondspe() {return $this->hassecondspe;}
	public function g_speactive() {return $this->speactive;}
	public function g_hf() {return $this->hf;}
	public function g_vh() {return $this->vh;}
	public function g_metier1($t=null) {if(isset($t)){return $this->metier1[$t];}return $this->metier1;}
	public function g_metier2($t=null) {if(isset($t)){return $this->metier2[$t];}return $this->metier2;}
	public function g_spe1($t=null) {if(isset($t)){return $this->spe1[$t];}return $this->spe1;}
	public function g_spe2($t=null) {if(isset($t)){return $this->spe2[$t];}return $this->spe2;}
	public function g_spedata($t=null) {if(isset($t)){return $this->spedata[$t];}return $this->spedata;}
	public function g_time($t=null) {return $this->time;}
	
	
	/*------------------- DRAW -------------------*/
	public function Draw_visu()
	{
		return '<iframe src="http://'.$this->config[($this->zone)].'/character-model-embed.xml?r='.$this->server_url.'&cn='.urlencode($this->name).'" scrolling="no" height="443" width="321" frameborder="0"></iframe>';
	}
	
	public function Draw_url()
	{
		return 	'http://'.$this->config[($this->zone)].'/character-sheet.xml?r='.$this->server_url.'&cn='.urlencode($this->name);
	}
	
	public function Draw_guildurl()
	{
		return 	'http://'.$this->config[($this->zone)].'/guild-info.xml?r='.$this->server_url.'&gn='.str_replace(' ','+',$this->guild);
	}
	
	public function Draw_activitifeed()
	{
		return 'http://'.$this->config[($this->zone)].'/character-feed.xml?r='.$this->server_url.'&cn='.urlencode($this->name);
	}
	
	public function Draw_portrait()
	{
		$low = '';
		if($this->lvl < 80)
			$low = 'low/';
		return 'img/avatars/'.$low.$this->sexe.'-'.$this->race.'-'.$this->classe.'.gif';
	}
	
	/*------------------- XML -------------------*/
	function get_perso_xml()
	{

		ini_set("user_agent", "Mozilla/5.0 (X11; U; Linux i686; pl-PL; rv:1.9.0.2) Gecko/20121223 Ubuntu/9.25 (jaunty) Firefox/3.8");
		$url = $this->Draw_url();
		$xml = null;
		//$url = 'http://192.168.0.25';
		$xml = @simplexml_load_file($url);
		
		if(!$xml['requestUrl'] == '/character-sheet.xml')
			return null;

		return $xml;
	}
}

function getracename($race)
{
	global $ll;
	$raceTAB = array(
		$ll->str('unkown'),
		$ll->str('r_humain'),
		$ll->str('r_orc'),
		$ll->str('r_nain'),
		$ll->str('r_elfedelanuit'),
		$ll->str('r_mortvivant'),
		$ll->str('r_tauren'),
		$ll->str('r_gnome'),
		$ll->str('r_troll'),
		$ll->str('unkown'),
		$ll->str('r_elfedesang'),
		$ll->str('r_draenie'),
	);
	
	if($race>11 || $race<1)
		return $raceTAB[0];
	
	return $raceTAB[($race)];
}

function getsexename($sexe)
{
	global $ll;
	$sexeTAB = array(
		$ll->str('unkown'),
		$ll->str('m'),
		$ll->str('f')
	);
	
	$sexe = $sexe + 1;	
	if($sexe>2 || $sexe<1)
		return $sexeTAB[0];
	
	return $sexeTAB[($sexe)];
}

function getclassname($class)
{
	global $ll;
	$classTAB = array(
		$ll->str('unkown'),
		$ll->str('c_guerrier'),
		$ll->str('c_paladin'),
		$ll->str('c_chasseur'),
		$ll->str('c_voleur'),
		$ll->str('c_pretre'),
		$ll->str('c_chevalierdelamort'),
		$ll->str('c_chaman'),
		$ll->str('c_mage'),
		$ll->str('c_demoniste'),
		$ll->str('unkown'),
		$ll->str('c_druide'),
	);
		
	if($class>11 || $class<1)
		return $classTAB[0];
	
	return $classTAB[($class)];
}

function getmetiername($metier)
{
	global $ll;
	return $ll->str('m_'.$metier);
}

function getthedate($time)
{
	global $ll;
	return $ll->str('lastupdate').date($ll->str('dateformat',$time));
}

function getspename($c,$a1,$a2,$a3)
{
	global $ll;
	
	$arbre = 0;
	
	// detection de l'arbre principal
	if($a1 > $a2 && $a1 > $a3)
	{
			$arbre = 1;
	}
	else if($a2 > $a1 && $a2 > $a3)
	{
			$arbre = 2;
	}
	else
	{
			$arbre = 3;
	}
	
	//return $arbre.'='.$a1.'/'.$a2.'/'.$a3;
	
	$classTAB = array(
		$ll->str('unkown'),
		$ll->str('s_guerrier_arbre'.$arbre),
		$ll->str('s_paladin_arbre'.$arbre),
		$ll->str('s_chasseur_arbre'.$arbre),
		$ll->str('s_voleur_arbre'.$arbre),
		$ll->str('s_pretre_arbre'.$arbre),
		$ll->str('s_dk_arbre'.$arbre),
		$ll->str('s_chaman_arbre'.$arbre),
		$ll->str('s_mage_arbre'.$arbre),
		$ll->str('s_demoniste_arbre'.$arbre),
		$ll->str('unkown'),
		$ll->str('s_druide_arbre'.$arbre),
	);
	
	$c = $c + 0;	
	if($c>11 || $c<1)
		return $classTAB[0];
	
	return $classTAB[($c)];
}

?>
