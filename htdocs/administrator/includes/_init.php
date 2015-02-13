<?php
error_reporting(0);
	$time_start = microtime(true);
	include('_session.php');
	
	//Local
// define("ADMINPATH","c:/wamp/www/yoursportal.com/administrator/");
	// define("ADMINURL","http://localhost/yoursportal.com/administrator/");
	 
	 //Demo
	 define("ADMINPATH",$_SERVER['DOCUMENT_ROOT']."/yoursportal.com/administrator/");
	 define("ADMINURL","http://".$_SERVER['HTTP_HOST']."/yoursportal.com/administrator/");
	 
	 //Live
	// define("ADMINPATH",$_SERVER['DOCUMENT_ROOT']."/administrator/");
	 //define("ADMINURL","http://".$_SERVER['HTTP_HOST']."/administrator/");
	
	if($_GET)
	{
			$args = explode("&",$_SERVER['QUERY_STRING']);
			foreach($args as $arg)
			{
				$keyval = explode("=",$arg);
				if($keyval[0] != "lang")$queryString .= "&" . $arg;
			}
	}

	if(isset($_GET['lang']) && !empty($_GET['lang']))
	{
		$_SESSION['language'] = $_GET['lang'];
	}else $_SESSION['language'] ='jp';
	include_once(ADMINPATH.'/helpers/class.menu.php');
    include_once(ADMINPATH.'/helpers/class.translation.php');
	include_once(ADMINPATH.'/helpers/class.language.php');
	
	$m = new Menu();
	$t = new Translation($_SESSION['language']);
	$objLanguage = new Language();
	$totalLanguages = $objLanguage->getTotalLanguage(); 
?>