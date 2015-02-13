<?php
include_once('class.dbobject.php');
class Menu extends DBObject  {
	var $uses = "mod_menu";

	function __construct($data=null)
	{
		parent::__construct($data,$this->uses);
	}
	function renderMenuAsOptions($sel_id)
	{
		$menu_mods = $this->Find();
		foreach($menu_mods as $m)
		{
			if($m->id == $sel_id)
			{
				print "<option value=\"$m->id\" selected=\"selected\">$m->menu_name</option>";
			} 
			else
			{
				print "<option value=\"$m->id\">$m->menu_name</option>";
			}
		}
	}
	function Find($limit = null,$id = 'all',$field='t.id',$order='desc',$cols=array('id'))
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if(intval($id) > 0)
					{
						$sql = "select t.* from ".$this->_uses." t where t.id = ".$id." order by $field $order limit 0,1";
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$item = $result->fetch();
					}
					else
					{
						if($id=='all')
						{
							$sql = "select t.*,l.abbr from ".$this->_uses." t left join languages l on t.language_id = l.id order by $field $order $limit";
						}else
						{
							$sql = "select ".join(',',$cols)." from ".$this->_uses." t left join languages l on t.language_id = l.id order by $field $order $limit";
						} 	
						//print $sql;
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						while($data = $result->fetch())
						{
							$item[] = $data;
						}
					}
				}
			catch(Exception $e)
				{
				 	  //exception $e->getMessage()
				}
		return $item;
	}
}
?>