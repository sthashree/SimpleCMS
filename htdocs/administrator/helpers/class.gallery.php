<?php
include_once('class.dbobject.php');
class Gallery extends DBObject  {
	var $uses = "stha_gallery";
	var $tblPhoto = "stha_photo";
	var $tblConfigure = "stha_config";
	var $_files;
	var $_data;
	function __construct($data='',$file='')
	{
		parent::__construct($data,$this->uses);
		$this->_files = $file;
		$this->_data = $data;
	}
	
	function getConfigure()
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select * from ".$this->tblConfigure;			  			
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
	
	function saveConfig()
	{
		
		global $CONN_STRING,$USER_NAME,$PWD;
		$countPhoto = count($this->_data);
		for($i=0;$i<$countPhoto;$i++)
		{
			foreach($this->_data[$i] as $key=>$val)
			{
				echo $elements[] = $key;
				echo $element_values[] = $val;
				try{
									
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
						$stmt = "update ".$this->tblConfigure." set title = '$key', value = '$val' where id = '".($i+1)."'";
					$result = $conn->query(trim($stmt));
						if(isset($result)) $status = TRUE;
						
					}
					catch(Exception $e)
					{
				 		print $e->getMessage();
					}
			
			}
		}
		return $status;		
	}
	
	function Save($id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		include("class.imageupload.php");
		$imageUpload = new ImageUpload($this->_files,1);    //first Parameter file 2nd parameter for thumbnail. 0 for no thumbnail and 1 for thumbnaiel
		$imageStatus = $imageUpload->upload();
		
		if($imageStatus['UPLOAD_OK'])
		{
			$elements[] = "logo";
			$element_values[] = $imageStatus['UPLOAD_FILE_NAME'];
		}
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
					$sql = "select t.id,t.gallery_name,dATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,t.gallery_description,u.username from $this->_uses t inner join stha_users u on t.user_id = u.id where $search_string $limit";			  			
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
	function increaseHits($id)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$sql = "update  ".$this->_uses." t set t.hits = t.hits+1 where t.id = $id and t.published = 1";
					//print $sql;	  			
					$result = $conn->query(trim($sql));
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
						$sql = "select t.* from ".$this->_uses." t where t.id = ".$id." order by $field $order limit 0,1";
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
							$sql = "select t.id,t.gallery_name,t.galleryname_alias,t.logo,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,u.username from ".$this->_uses." t inner join stha_users u on t.user_id = u.id $where order by t.$field $order $limit";
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
	function Delete($id)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					
					$member = $this->Find(0,null,$id);
					unlink("photo/".$member->photo);
					unlink("photo/thumb/".$member->photo);

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
	
	function SearchPhoto($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.id,t.photo,t.photo_description,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date from stha_photo t where ".$search_string." order by id desc $limit";			  			
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
	
	function FindPhoto($category=0, $limit = null, $id = 0, $field='t.id',$order='desc',$language = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if(intval($id) > 0)
					{
						$sql = "select t.* from ".$this->tblPhoto." t where t.id = ".$id." order by $field $order limit 0,1";
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$item = $result->fetch();
					}
					else
					{
						if($category>0)
						{
							$where = " and t.gallery_id = $category";
							if($language > 0)
							{
								$where .= " and t.language_id = $language";
							}
						$sql = "select t.*,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,c.* from ".$this->tblPhoto." t inner join ".$this->_uses." c on t.gallery_id = c.id where final !=0 $where order by $field $order $limit";
						}
					else {
						$sql = "select t.*,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,c.* from ".$this->tblPhoto." t inner join ".$this->_uses." c on t.gallery_id = c.id inner join stha_users u on t.user_id = u.id where final !=0 order by $field $order $limit";
					
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
				 	  //exception $e->getMessage()
				}
		return $item;
	}
	
	function SavePhoto($id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		$countPhoto = count($this->_data);
		if(is_array($this->_data))
		{
		for($i=1;$i<=$countPhoto;$i++)
		{
			foreach($this->_data[$i] as $key=>$val)
			{
				echo $key;
				if($key!='id')
				{
					if($key!='photo')
					{
						$elements[] = $key;
						$element_values[] = $val;
					}
					//Photo name are not renaming
				/*	else
					{
						//require_once("configure.php");
						$ext=explode('.',$val);
						$ext=$ext[count($ext)-1];
						$name=time().$i.".".$ext;
						rename("../uploads/".$val ,"../uploads/".$name);
						rename("../uploads/thumb/".$val ,"../uploads/thumb/".$name);
					}*/
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
					//	$elements[]='photo';
						//$element_values[]=$name;				
						$stmt = $conn->prepare("update ".$this->tblPhoto." set ".join(' = ?,',$elements)." = ? where id = ".$id);
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
		return $status;
	}

	function DeletePhoto($id)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					
					$photo = $this->Find(0,null,$id);
					unlink("uploads/".$member->photo);
					unlink("uploads/thumb/".$member->photo);

					$stmt = $conn->prepare("delete from ".$this->tblPhoto." where id = ? limit 1");
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