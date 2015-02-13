<?php
include_once('class.dbobject.php');
class Movie extends DBObject  {
	var $uses = "stha_movie";
	var $_files;
	var $_data;
	function __construct($data='',$file='')
	{
		parent::__construct($data,$this->uses);
		$this->_files = $file;
		$this->_data = $data;
	}
	
	function Find( $external="", $limit = null, $id = 0, $field='id',$order='desc',$language = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($external !="")	$where = "external = '$external'";
					if(intval($id) > 0)
					{
						$sql = "select t.* from ".$this->_uses." t where t.id = ".$id." ". $where." order by $field $order $limit";
						
					}
					else
					{
						{
							if($language > 0)
							{
								$where .= " t.language_id = $language";
							}
							if(isset($where) && $where!="") $where = "where ".$where;
							$sql = "select t.* from ".$this->_uses." t ". $where." order by $field $order $limit";
						}		  			
						
					}
					$result = $conn->query(trim($sql));
					$result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
					while($data = $result->fetch())
					{
						$item[] = $data;
					}
				}
			catch(Exception $e)
				{
				 	  //exception $e->getMessage();
				}
		return $item;
	}
	
	function Search($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.*,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date from ".$this->_uses." t where ".$search_string." order by id desc $limit";			  			
					$result = $conn->query(trim($sql));
				    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
					while($data = $result->fetch())
					{
						$item[] = $data;
					}
				}
			catch(Exception $e)
				{
				 	  //exception $e->getMessage()
				}
		return $item;
	}
	
	function Save($id = 0)
	{
		//var_dump();
		global $CONN_STRING,$USER_NAME,$PWD;
		$countPhoto = count($this->_data);
		if(is_array($this->_data))
		{
		for($i=1;$i<=$countPhoto;$i++)
		{
			foreach($this->_data[$i] as $key=>$val)
			{
				
				//echo $key;
				if($key!='id')
				{
					if($key!='link')
					{
						$elements[] = $key;
						$element_values[] = $val;
					}
					else if($this->_data[$i]['external']==0)
					{
						//require_once("configure.php");
						$ext=explode('.',$val);
						$ext=$ext[count($ext)-1];
						$name=time().$i.".".$ext;
						rename("../movie/movie/".$val ,"../movie/movie/".$name);
					}
					else
					{
						
						echo $name = $val;
					}
				}
				else
				{
					$id = $val;
					
				}
			}
			try{
									
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
						$elements[]="final";
						$element_values[]="1";	
						$elements[]='link';
						$element_values[]=$name;
						$elements[]="user_id";
						 $element_values[]=$this->_data['user_id'];
						$elements[]="language_id";
						$element_values[]=$this->_data['language_id'];
						
						//var_dump($elements);
										
						$stmt = $conn->prepare("update ".$this->_uses." set ".join(' = ?,',$elements)." = ? where id = ".$id);
  			  			$stmt->execute($element_values);
						if($stmt->rowCount()>0){
							$status = TRUE;
						}
						//else{
							//$status = FALSE;
						//}
					}
					
			catch(Exception $e)
				{
				 	  print $e->getMessage();
				}
			}
		}
		//die;
		return $status;
	}
function SaveExternalLink($id = 0)
	{
		//var_dump();
		global $CONN_STRING,$USER_NAME,$PWD;
		$countPhoto = count($this->_data);
		if(is_array($this->_data))
		{
		foreach($this->_data as $key=>$val)
			{
				$elements[] = $key;
				$element_values[] = $val;
					
			}
			try{
									
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
						//var_dump($elements);
						//echo "insert into ".$this->_uses."(".join(',',$elements).") values(".what(count($elements)).")";
						  $stmt = $conn->prepare("insert into ".$this->_uses."(".join(',',$elements).") values(".what(count($elements)).")");
						  $stmt->execute($element_values);
						  if($stmt->rowCount()>0){
								$status = TRUE;
							}else{
								$status = FALSE;
							}
				}	
			catch(Exception $e)
				{
				 	  print $e->getMessage();
				}
			//	die;
		return $status;
	}
}

	function Delete($id)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					
					$movie = $this->Find(0,null,$id);
					unlink("movie/".$movie->link);
					
					$stmt = $conn->prepare("delete from ".$this->_uses." where id = ? limit 1");
					$stmt->execute(array($id));
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
	
}
?>