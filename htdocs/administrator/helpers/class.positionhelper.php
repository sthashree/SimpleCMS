<?php
class PositionHelper
{
	var $layout_xml = null;
	
	function __construct($xml_path)
	{
	    $this->layout_xml = simplexml_load_file($xml_path);
	}
   function renderPositionOptions($p = 0)
   {
	foreach($this->layout_xml->position as $position)
	{
		if($p == $position['id']){
			print '<option value="'.$position['id'].'" selected="selected">'.$position.'</option>';
		}else{
			print '<option value="'.$position['id'].'">'.$position.'</option>';
		}
	}
   }
   
   function getIdByPosition($p)
   {
   		foreach($this->layout_xml->position as $position)
		{
			if(strcmp($position, $p)==0){return $position['id'];}
		}
		return 0;
   }
   
   function getPositionById($id)
   {
   		foreach($this->layout_xml->position as $position)
		{
			if($position['id']==$id){return $position;}
		}
		return 0;
   }
}
?>