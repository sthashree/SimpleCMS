<?php
include_once('class.dbobject.php');
class Map extends DBObject  {
	var $uses = "stha_googlemap";
	var $_files;
	var $_data;
	function __construct($data='',$file='')
	{
		parent::__construct($data,$this->uses);
		$this->_files = $file;
		$this->_data = $data;
	}
	
	
	function Save($id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		include("class.imageupload.php");
		$imageUpload = new ImageUpload($this->_files,1);    //first Parameter file 2nd parameter for thumbnail. 0 for no thumbnail and 1 for thumbnail
		$imageStatus = $imageUpload->upload();
		if($imageStatus['UPLOAD_OK'])
		{
			$elements[] = "icon";
			$element_values[] = $imageStatus['UPLOAD_FILE_NAME'];
		}
		$elements[]="language_id";
		$element_values[]=$_SESSION['language'];
		$status = FALSE;
		if(is_array($this->_data))
		{
			$images= $this->_data['photo'];
			foreach($this->_data as $key=>$val)
			{
				$elements[] = $key;
				$element_values[] = $val;
			}
			try{
				
				//var_dump($elements);
					//\\echo $this->_uses;
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($id > 0)
					{
						
						$stmt = $conn->prepare("update ".$this->_uses." set ".join(' = ?,',$elements)." = ? where id = ".$id);
  			  			$stmt->execute($element_values);
						if($stmt->rowCount()>0){
							$status = TRUE;
						}else{
							$status = FALSE;
						}
					}
					else
					{
				
						  $stmt = $conn->prepare("insert into ".$this->_uses."(".join(',',$elements).") values(".what(count($elements)).")");
						  $stmt->execute($element_values);
						  if($stmt->rowCount()>0){
								$status = TRUE;
							}else{
								$status = FALSE;
							}
					}
				}
			catch(Exception $e)
				{
				 	  print $e->getMessage();
				}
		}
		//die;
		return $status;
	}

	
	function Search($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($search_string!="") $where = " where ".$search_string;
					$sql = "select t.id,t.title,t.description,t.icon from ".$this->_uses." ".$where." ".$limit;			  			
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
	
	function Find( $category=0, $limit = null, $id = 0, $field='id',$order='desc',$language = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if(intval($id) > 0)
					{
						$sql = "select t.* from ".$this->_uses." t where t.id = ".$id." order by $field $order";
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$item = $result->fetch();
					}
					else
					{
						{
							if($language > 0)
							{
								$where .= "where t.language_id = $language";
							}
							echo $sql = "select t.* from ".$this->_uses." t where t.id = ".$id." order by $field $order $limit";
						}		  			
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
				 	  //exception $e->getMessage();
				}
		return $item;
	}
	
	function getMap($lang = 'en', $limit = null, $field='id',$order='desc')
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.* from ".$this->_uses." t order by $field $order $limit";
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
	function Delete($id)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					
					$map = $this->Find(0,null,$id);
					unlink("photo/".$map->photo);
					unlink("photo/thumb/".$map->photo);

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
	
	function getLatLong() {
		$results = $this->getMap();
		foreach($results as $key =>$result) {
			//var_dump($result);
			$array[$key]['lat']=$result->lat;
			$array[$key]['long']=$result->lon;
			$array[$key]['icon']=$result->icon;
			$array[$key]['description']=$result->description;
			$array[$key]['link']=$result->link;
		}
	return $array;
	}
}
?>