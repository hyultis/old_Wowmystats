<?php
// ll.class.php v1.0.1
// use LGPL licence
// more info : http://hyultis.monespace.net on "hfw" project

// class
class hfw_ll
{
	// var
	var $lang = array();
	var $pathlang = '';

	// constructor
	// $lang = initial lang (if not exist return to english)
	// $basepath = path to find lang file
	// $detect => no work for the moment (use visitor's lang, if not exist return to initial lang) 
	function __construct($lang = 'en',$basepath = 'loc/',$detect = false)
	{
		// init
		$this->lang = array();
		$this->pathlang = $lang;

		// langue detecte
		if($detect)
		{
			$visiteurlang = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
			$this->pathlang = strtolower(substr(chop($visiteurlang[0]),0,2));
		}

		if(!file_exists($basepath.$this->pathlang.'.php') || !$this->pathlang || $this->pathlang=='')
			$this->pathlang = 'en';

		include($basepath.$this->pathlang.'.php');
	}

	// return translate from lang
	// $loc_name => translate name
	// $arraydata => array ( string data , ...) 
	function str($loc_name,$arraydata='')
	{
		$finalstr = '';
		if(isset($this->lang[$loc_name]))
		{
			$finalstr = $this->lang[($loc_name)];
			for($t=0;$t<count($arraydata);$t++)
			{
				if(substr_count($finalstr, '%'.$t)>0)
					$finalstr = str_replace('%'.$t,$arraydata[$t],$finalstr);
			}
		}
		else if(isset($this->lang['hfw_ll_error']))
			$finalstr = $this->str('hfw_ll_error',array($loc_name));
		else
			$finalstr = 'Translate "'.$loc_name.'" unkown';
		
		return $finalstr;
	}

	// same as 'str' fonction, but use array instead of 2 params
	// $params = array(
	//  "name" => translate name
	//  "array" => array ( string data , ...) 
	// )
	function str_array($params)
	{
		if(!isset($params['name']))
			return false;

		return $this->str($params['name'],explode("|",$params['array']));
	}

	// return the ll array
	function lang_array()
	{
		return $this->lang;
	}

	// add ll to exist ll
	function add_loc($add)
	{
		$this->lang = array_merge($this->lang,$add);
	}

	// return actual lang
	function get_lang()
	{
		return $this->pathlang;
	}
}
?>
