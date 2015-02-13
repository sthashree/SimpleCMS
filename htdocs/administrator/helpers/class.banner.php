<?php
include_once('class.dbobject.php');
class Banner extends DBObject  {
	var $uses = "stha_banner";
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
		$imageUpload = new ImageUpload($this->_files,1,"photo/");    //first Parameter file 2nd parameter for thumbnail. 0 for no thumbnail and 1 for thumbnail
		$imageStatus = $imageUpload->upload();
		if($imageStatus['UPLOAD_OK'])
		{
			$elements[] = "image";
			$element_values[] = $imageStatus['UPLOAD_FILE_NAME'];
		}
		$status = FALSE;
		//var_dump($this->_data);
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
				  $sql = "select max(t.ordering) as ordering from $this->_uses as t";			  			
				  $result = $conn->query(trim($sql));
				  $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
				  $i=0;
				  $orders = $result->fetch();
				  $elements[]='ordering';
				  $element_values[]=$orders->ordering+1;
		  
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
	
	function saveorder($data)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
				  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				  $conn->query("SET CHARACTER SET utf8");
				  $conn->query("SET SESSION collation_connection='utf8_general_ci'");
		foreach($data as $key => $value) {
			echo $sql ="update ".$this->_uses." set ordering ='$value' where id='$key'";
			if($conn->query($sql)){
				$status = TRUE;
			}
			else {
				$status = FALSE;
			}
		}
		//die;
		return $status;
		
	}


	
	function getBanner($where="",$id=0,$limit="")
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if(intval($id) > 0)
					{
						$sql = "select t.* from ".$this->_uses." t where t.published ='1' and t.id = ".$id." order by t.ordering asc limit 0,1";
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$item = $result->fetch();
					}
					else {
						$sql = "select t.* from $this->_uses as t where t.published='1' and ispublic='1' $where order by ordering asc $limit";			  			
						$result = $conn->query(trim($sql));
						$result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$i=0;
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
	
	
	
	function Search($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					echo $sql = "select t.*,dATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,u.username from $this->_uses t inner join stha_users u on t.user_id = u.id where $search_string order by ordering desc $limit";			  			
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
	
	
	
	function Find( $category=0, $limit = null, $id = 0, $field='ordering',$order='asc',$language = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if(intval($id) > 0)
					{
						$sql = "select t.* from ".$this->_uses." t where t.id = ".$id." order by $field $order $limit";
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
							$sql = "select t.* from ".$this->_uses." t inner join stha_users u on t.user_id = u.id $where order by $field $order $limit";
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
					unlink("photo/".$member->image);
					unlink("photo/thumb/".$member->image);
					//die;

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