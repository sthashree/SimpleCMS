<?php
include_once('class.dbobject.php');
class Language extends DBObject  {
	var $uses = "languages";

	function __construct($data=null)
	{
		parent::__construct($data,$this->uses);
	}
	function renderLanguageAsOptions($sel_id)
	{
		$languages = $this->Find();
		foreach($languages as $l)
		{
			if($l->id == $sel_id)
			{
				print "<option value=\"$l->id\" selected=\"selected\">$l->language</option>";
			} 
			else
			{
				print "<option value=\"$l->id\">$l->language</option>";
			}
		}
	}
	
	function isValidLanguage($abbr)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(!empty($abbr))
		{
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

					$stmt = $conn->prepare("select id from ".$this->_uses." where abbr = ? limit 1");
					$stmt->execute(array($abbr));
					if($stmt->rowCount()>0){
						$status = TRUE;
					}else{
						$status = FALSE;
					}
				}
			catch(Exception $e)
				{
				 	  //print $e->getMessage();
				}
		}
		return $status;
	}
	
	function getTotalLanguage()
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

					$sql = ("select * from ".$this->_uses." where published = 1 ");
					$result = $conn->query(trim($sql));
				    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
					$i=0;
					while($data = $result->fetch())
					{
					 $item[] = $data;
					}
				}
			catch(Exception $e)
				{
				 	  //print $e->getMessage();
				}
		return $item;
	}
	function getId($abbr)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(!empty($abbr))
		{
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

					$stmt = $conn->prepare("select id from ".$this->_uses." where abbr = ? limit 1");
					$stmt->execute(array($abbr));
					 $stmt->setFetchMode(PDO::FETCH_CLASS,Stdclass);
					$i=0;
					$data = $stmt->fetch();
									
					if($stmt->rowCount()>0){
						$status = $data->id;
					}else{
						$status = FALSE;
					}
				}
			catch(Exception $e)
				{
				 	  //print $e->getMessage();
				}
		}
		return $status;
	}
}
?>