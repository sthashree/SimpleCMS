<?php
// key = array ( array('name'=>'field','type'=>'numeric') );
    function validate($input,$keys)
	{
		foreach($keys as $key)
		{
			switch($key['type'])
			{
				case 'numeric':
							 if( intval($input[$key['name']]) <= 0 )
							 {
							 	return FALSE;
							 } 
							 break;
				case 'string':
							 if( empty($input[$key['name']]) )
							 {
							 	return FALSE;
							 } 
							 break;
			}
		}
		return TRUE;
	}
	
	function trim_array($data)
	{
		foreach($data as $key=>$val)
		{
			$data[$key] = trim($val);
		}
		return $data;
	}
	
	function what($num)
	{
		for($i=0;$i<$num;$i++){
			$ret[] = '?';
		}
		return join(',',$ret);
	}
	
	function SelectList($name,$datas,$field,$value='',$func='',$select='')
	{
		global $db;
		if($select=="") $select ="Select One";
		if($func!=""){ $change="onChange='$func'";}
		$return="<select name=".$name." id=".$name." ". $change.">";
		$return.="<option value=0> ".$select ." </option>";
		if(is_array($datas)) {
			foreach($datas as $data)
			{
				$return.="<option value='".$data->id."'";
				if($data->id==$value) { $return.="selected='selected'";  }
			 	$return.=">".$data->$field."</option>";
			}
		}	
		$return.="</select>";
		return $return;
		
	}
	
	function makeClean($string)
	{
		if(!function_exists('mysql_escape_string'))	{
			return addslashes($string);
		}
		else
		{
			return mysql_escape_string($string);
		}
	}
	
	function StringToArray($string)
	{
		return explode(",",$string);
	}
	function setTime($data)
	{
		$return = $data['day']." ".$data['hour']."-".$data['minute']."-"."0";
		return $return;
	}
	
	function getTime($data)
	{
		$hours = explode(" ",$data);
		$return[day]=$hours[0];
		$minutes = explode(":",$hours[1]);
		$return[hour]=$minutes[0];
		$return['minute']=$minutes[1]; 
		return $return;
	}
	
	function cleanPage($item)
	{
		$cleanItem=makeClean($item);
		$pages=explode("-",$cleanItem);
		return $pages;
	}
	
	function getCategoryFromUrl($item)
	{
		$cleanItem=makeClean($item);
		$pages=explode("-",$cleanItem);
		//var_dump($pages);
		return $pages[0];	
	}
	
	function getLanguageSpecific($data,$abbr) {
		$pattern="/\[".$abbr."\](.*?)\[\/".$abbr."\]/";

	//	$str = "dsfs[en]gdsjhghjs[/en]dhjsghj";
		$lanPreg = preg_match($pattern, $data, $m);
		$pattern1 = "/\[".$abbr."\]/";
		$pattern2 = "/\[\/".$abbr."\]/";
		$replacement = ' ';
		$return = preg_replace($pattern2, $replacement, preg_replace($pattern1, $replacement, $m[0]));
		
		return $return;
	
	}
	function getLanguageBar($totalLanguages) {
		//var_dump($_SESSION);
		foreach($totalLanguages as $language) {  
			
		//	echo $language->abbr;
			if($_SESSION['language']!=$language->abbr) { 
			//echo $language->abbr;
			$strings=explode("/",$_SERVER['REQUEST_URI']);
			//var_dump($strings);
			$url=BASEURL;
			foreach($strings as $key => $string)
			{
				if($key!=0 && $key!=1)
				{
					
				//echo $key;
					if($key == (count($strings)-1)) {
						$lang=explode("=",$string);
					}
					if(count($lang)<2) {
						$url.="/".$string;
					}
				}
			}
				$return .= '<a href="'.$url.'/lang='.$language->abbr.'"><img src="'.BASEURL.'images/'.$language->abbr.'.png" alt ="'.$language->abbr.'" /></a>';
			}
    	}
		
		return $return; 
	}	
	
	function userAuthorized($component) {
		if(in_array($component,$_SESSION['authorized'])) {
						$status = TRUE;
		}
		else {
			$status = FALSE;
		}
		return $status;
	}
	
	function output($content) {
		return stripslashes($content);
	}
	
	function checkLogged() {
		if(isset($_SESSION['user_id']) && ($_SESSION['user_id'])!="") {
				return true;	
		}
		else { 
			return false;
		}
	}
	
	function giveNextUrl() {
		$urlwithHtm =explode(".",$_SERVER['REQUEST_URI']);
		$url=explode("/",$urlwithHtm[0]);
		$i=0;
		foreach($url as $key => $uri)
		{
			if($i!=0 && $key!="status") {
			  $actualUrl.=  $uri;
			  if($i<(count($url)-1))
			  $actualUrl.="/";
			}
		  $i++;
		}
		return $actualUrl;
	}
	
	function getExtension($file) {
		$file_array = explode(".",$file);
		//var_dump($file_array);
		$extension = $file_array[count($file_array)-1];
		return strtolower($extension);
	}
	
	function getFileSize($file){
		$filesizeInByte = filesize($file);
		$filesizeInKB = $filesizeInByte/1024;
		$filesizeInMB = $filesizeInKB/1024;
		return round($filesizeInMB,2); 
	}
?>