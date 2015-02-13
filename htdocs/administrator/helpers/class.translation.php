<?php
class Translation
{
	var $xml_simple_obj = null;
	function __construct($language = 'en')
	{
	//	echo ADMINPATH;
		if(file_exists(ADMINPATH.'/languages/'.$language.'.xml')){
			$this->xml_simple_obj = simplexml_load_file(ADMINPATH.'/languages/'.$language.'.xml');
		}else{
			$this->xml_simple_obj = simplexml_load_file(ADMINPATH.'/languages/en.xml');
		}
	}
	function translate($key)
	{
		list($settings) = $this->xml_simple_obj->xpath($key);
		return $settings;
	}
}
	
?>