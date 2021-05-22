<?php


function findAttribute($object, $attribute)
{
	foreach($object->attributes() as $a => $b)
	{
		if ($a == $attribute)
			$return = $b;
	}
	if($return)
		return $return;
	return null;
}

function get_last_xml_time($server,$name)
{
	$lasttime = -1;
	
	if ($dh = opendir('cache/'.$server.'/'.$name))
	{
		while (($file = readdir($dh)) !== false)
		{
			$file = explode('.',$file);
			if($file[0] > $lasttime)
				$lasttime = $file[0];
			
		}
		closedir($dh);
	}
	
	return $lasttime;
}


function get_perso_xml($server,$name,$config,$refreshfromarmory = false)
{

	ini_set("user_agent", "Mozilla/5.0 (X11; U; Linux i686; pl-PL; rv:1.9.0.2) Gecko/20121223 Ubuntu/9.25 (jaunty) Firefox/3.8");
	$timestamp = time();
	$server = str_replace(" ","+",$server);
	$time = get_last_xml_time($server,$name);
	
	if($time>-1)
	{
		if(($timestamp > $time+3600*24) && $refreshfromarmory)
		{
			echo "test";
			//$urlcache='cache/'$server'_'.$name.'_'.$timestamp.'.xml';
		}
	}
	else
	{
		// force refresh
	}
	
	$url='cache/'.$server.'/'.$name.'/'.$time.'.xml';
	if(file_exists($url))
		return simplexml_load_file($url);

	return null;
}

?>
