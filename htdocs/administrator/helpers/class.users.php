<?php
include_once('class.dbobject.php');
class Users extends DBObject  {
	var $uses = "stha_users";
	var $user_type="stha_usertype";
	var $tblUserRoles="stha_userroles";
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
			$elements[] = "photo";
			$element_values[] = $imageStatus['UPLOAD_FILE_NAME'];
		}
		$status = FALSE;
		if(is_array($this->_data))
		{
			$images= $this->_data['photo'];
			foreach($this->_data as $key=>$val)
			{
				$elements[] = $key;
				if($key!="password") {
					$element_values[] = $val;
				}
				else
				{
					$element_values[]=md5($val);
				}
			}
			try{
				
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($id > 0)
					{
						echo "23";
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
						echo "insert into ".$this->_uses."(".join(',',$elements).") values(".what(count($elements)).")";
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
					$sql = "select t.id,t.firstname,t.midlename,t.lastname,dATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,t.short_description,u.username,match(t.firstname) against ('$search_string' IN BOOLEAN MODE) as relevancy from $this->_uses t inner join stha_users u on t.user_id = u.id where match(t.firstname) against ('$search_string' IN BOOLEAN MODE) order by relevancy desc $limit";			  			
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
	
	function Find($id = 0,$field='id',$limit = null, $order='desc',$language = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if(intval($id) > 0)
					{
						$sql = "select t.*,u.type,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date from ".$this->_uses." t inner join ". $this->user_type." u on t.user_type = u.id where t.".$field ."= '".$id."' order by $field $order limit 0,1";
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
							$sql = "select t.*,u.type,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date from ".$this->_uses." t inner join ". $this->user_type." u on t.user_type = u.id $where order by $field $order $limit";
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
	function getUser($where='', $lang = 'en', $limit = null, $field='id',$order='desc')
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					echo $sql = "select t.firstname,t.lastname,t.id,t.middlename,t.photo,t.email,t.published,DATE_FORMAT(t.modified_date,'%d.%m.%Y') as modified_date,t.username from ".$this->_uses." t  where $where order by $field $order $limit";
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
	
	function Activate($id,$stat)
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
					$stat = 1-$stat;
					$stmt = $conn->prepare("update ".$this->_uses." set active = ".$stat." where id = ? limit 1");
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
	
	function ValidUsername($username,$update='')
	{
		
		$status = TRUE;
		$searchString = " username = '$username' ";
		if(isset($update) && $update!="")
		{
			$searchString.=" and id!='$update' ";
		}
		$Users = $this->getUser($searchString);
		if(is_array($Users))
		{
			$status =FALSE;
		}
		return $status;
		
	}
	
	function getUserAuthenticate($id) {
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					 $sql = "select t.*,t.published,DATE_FORMAT(t.modified_date,'%d.%m.%Y') as modified_date,t.username,u.roles as roles from ".$this->_uses." as t join ".$this->user_type." as u on t.user_type = u.id  where t.id='$id' ";
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$data = $result->fetch();
						$roles = explode(",",$data->roles);
						foreach($roles as $key => $role )
						{
							$qry = "select q.* from $this->tblUserRoles as q where q.id='".$role."'";
							$result_role = $conn->query(trim($qry));
					    	$result_role->setFetchMode(PDO::FETCH_CLASS,Stdclass);
							$data_role = $result_role->fetch();
							$authorized[]=$data_role->role_alias;
							
						
						}
				}
			catch(Exception $e)
				{
				 	  //exception $e->getMessage()
				}
		return $authorized;
	}
}
?>