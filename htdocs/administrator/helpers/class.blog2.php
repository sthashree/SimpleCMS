<?php
include_once('class.dbobject.php');
class Blog extends DBObject  {
	var $uses = "stha_blog_category";
	var $tblTitle = "stha_blog_content";
	var $tblComment = "stha_blog_comment";
	var $tblConfigure = "stha_config";
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
		$status = FALSE;
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
					$sql = "select t.*,DATE_FORMAT(t.updated_date,'%Y-%m-%d') as modified_date,u.username from $this->_uses t inner join stha_users u on t.user_id = u.id where $search_string order by id desc $limit";			  			
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
							$sql = "select t.*,DATE_FORMAT(t.updated_date,'%Y-%m-%d') as modified_date,u.username from ".$this->_uses." t inner join stha_users u on t.user_id = u.id $where order by t.$field $order $limit";
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
	function SaveTitle($id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		
		$status = FALSE;
		if(is_array($this->_data))
		{
			foreach($this->_data as $key=>$val)
			{
				$elements[] = $key;
				$element_values[] = $val;
			}
			//var_dump($elements);
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($id > 0)
					{
						
						$stmt = $conn->prepare("update ".$this->tblTitle." set ".join(' = ?,',$elements)." = ? where id = ".$id);
  			  			$stmt->execute($element_values);
						if($stmt->rowCount()>0){
							$status = TRUE;
						}else{
							$status = FALSE;
						}
					}
					else
					{
						//echo "insert into ".$this->tblTitle."(".join(',',$elements).") values(".what(count($elements)).")";	
						  $stmt = $conn->prepare("insert into ".$this->tblTitle."(".join(',',$elements).") values(".what(count($elements)).")");
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
	
		
	function SearchTitle($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.*,dATE_FORMAT(t.updated_date,'%Y-%m-%d') as modified_date from ".$this->tblTitle." t inner join stha_users u on t.user_id = u.id where $search_string order by id desc $limit";			  			
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

	
	
	function FindTitle( $category="", $limit = null, $id = 0, $field='id',$order='desc',$language = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($category!="" || $id!=0) $where= " where ";
					if($category!="") $where .= " category_id='$category'";
					if($id!=0) $where.=" t.id=$id";
					if(intval($id) > 0)
					{
						$sql = "select t.* from ".$this->tblTitle." t ".$where." order by $field $order $limit";
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$item = $result->fetch();
					}
					else
					{
						{
							if($language > 0)
							{
								$where .= " t.language_id = $language";
							}
						$sql = "select t.* from ".$this->tblTitle." t ".$where." order by $field $order $limit";
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
	
	function DeleteTitle($id)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//echo "delete from ".$this->tblTitle." where id = ? limit 1";
					$stmt = $conn->prepare("delete from ".$this->tblTitle." where id = ? limit 1");
					$stmt->execute(array($id));
					
					$stmt2 = $conn->prepare("delete from ".$this->tblComment." where blog_id = ? ");  //deletes the comments for this topic
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
	
	function PublishTitle($id,$stat)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
		//	echo $id;
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//echo "update ".$this->tblTitle." set published='$stat' where id = ?";
					$stmt = $conn->prepare("update ".$this->tblTitle." set published='$stat' where id = ?");
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
	//	die;
		return $status;
	}
	
	
	function SaveComment($id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		
		$status = FALSE;
		if(is_array($this->_data))
		{
			foreach($this->_data as $key=>$val)
			{
				$elements[] = $key;
				$element_values[] = $val;
			}
			//var_dump($elements);
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($id > 0)
					{
						
						$stmt = $conn->prepare("update ".$this->tblComment." set ".join(' = ?,',$elements)." = ? where id = ".$id);
  			  			$stmt->execute($element_values);
						if($stmt->rowCount()>0){
							$status = TRUE;
						}else{
							$status = FALSE;
						}
					}
					else
					{
						$stmt = $conn->prepare("insert into ".$this->tblComment."(".join(',',$elements).") values(".what(count($elements)).")");
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
	
		
	function SearchComment($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.*,dATE_FORMAT(t.commented_date,'%Y-%m-%d') as commented_date from ".$this->tblComment." t where $search_string order by id desc $limit";			  			
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

	
	
	function FindComment( $category="", $limit = null, $id = 0, $field='id',$order='desc',$language = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($category!="" || $id!=0) $where= " where ";
					if($category!="") $where .= " blog_id='$category'";
					if($id!=0) $where.=" t.id=$id";
					if(intval($id) > 0)
					{
						echo $sql = "select t.*,dATE_FORMAT(t.commented_date,'%Y-%m-%d') as commented_date from ".$this->tblComment." t ".$where." order by $field $order $limit";
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$item = $result->fetch();
					}
					else
					{
						{
							if($language > 0)
							{
								$where .= " t.language_id = $language";
							}
							$sql = "select t.*,dATE_FORMAT(t.commented_date,'%Y-%m-%d') as commented_date from ".$this->tblComment." t ".$where." order by $field $order $limit";
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
	
	function DeleteComment($id)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//echo "delete from ".$this->tblComment." where id = ? limit 1";
					$stmt = $conn->prepare("delete from ".$this->tblComment." where id = ? limit 1");
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
	
	function PublishComment($id,$stat)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
		//	echo $id;
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//echo "update ".$this->tblComment." set published='$stat' where id = ?";
					$stmt = $conn->prepare("update ".$this->tblComment." set published='$stat' where id = ?");
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
	//	die;
		return $status;
	}
	
	function isOwnTopic($user_id,$id) {
		if($user_id == $id) {
			return TRUE;
		}
		else {
			return FALSE;
		}

	}
	
	function countComment($id) {
		//echo $this->id;
	}

	function getParentCategory($id) {
		//echo $id;
		$subcategory = $this->Find("","",$id);
		$return['category'] = $subcategory->category_name;
		return $return;
	
	}
	
}
?>