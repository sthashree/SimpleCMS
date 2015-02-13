<?php
include_once('class.dbobject.php');
class Product extends DBObject  {
	var $uses = "stha_product_category";
	var $tblProduct = "stha_product";
	var $tblConfig ="stha_cart_config";
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
		//include("class.imageupload.php");
		//$imageUpload = new ImageUpload($this->_files,1);    //first Parameter file 2nd parameter for thumbnail. 0 for no thumbnail and 1 for thumbnaiel
		//$imageStatus = $imageUpload->upload();
		
	//	if($imageStatus['UPLOAD_OK'])
		//{
		//	$elements[] = "logo";
			//$element_values[] = $imageStatus['UPLOAD_FILE_NAME'];
		//}
		$status = FALSE;
		if(is_array($this->_data))
		{
			//$images= $this->_data['photo'];
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
					$sql = "select t.id,t.category_name,dATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,t.category_description,u.username,match(t.category_name) against ('$search_string' IN BOOLEAN MODE) as relevancy from $this->_uses t inner join stha_users u on t.user_id = u.id where match(t.category_name) against ('$search_string' IN BOOLEAN MODE) order by relevancy desc $limit";			  			
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
					$where = " parent_id='$category'";
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
							$sql = "select t.* from ".$this->_uses." t where ".$where." order by $field $order $limit";
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
	
	
	function getParentCategory($id) {
		//echo $id;
		$subcategory = $this->Find("","",$id);
		$return['category'] = $subcategory->category_name;
		if($subcategory->parent_id!=0) { 
		
			$category = $this->Find("","",$subcategory->parent_id);
			$return['category']=$category->category_name;
			$return['subcategory']=$subcategory->category_name;
		}
		return $return;
	
	}
	
	function SaveProduct($id = 0)
	{
		//var_dump($this->_files);
		global $CONN_STRING,$USER_NAME,$PWD;
		include("class.imageupload.php");
		$imageUpload = new ImageUpload($this->_files,1,"photo/");    //first Parameter file 2nd parameter for thumbnail. 0 for no thumbnail and 1 for thumbnaie
		$imageStatus = $imageUpload->upload();
		
		//die;
		if($imageStatus['UPLOAD_OK'])
		{
			$elements[] = "product_image";
			$element_values[] = $imageStatus['UPLOAD_FILE_NAME'];
		}
		$status = FALSE;
		if(is_array($this->_data))
		{
			var_dump($this->_data);
			$images= $this->_data['photo'];
			foreach($this->_data as $key=>$val)
			{
				$elements[] = $key;
				$element_values[] = $val;
				
				
				if($key == "todaySpecial" && $val=="1") { $todaySpecial =1; }
				//echo $todaySpecial.'this';
				
			}
			//var_dump($elements);
			//die;
			try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($todaySpecial==1) {
						$stmt2 = $conn->prepare("update ".$this->tblProduct." set todaySpecial = '0' ");
						$stmt2->execute();
						
					}
					if($id > 0)
					{
						
						$stmt = $conn->prepare("update ".$this->tblProduct." set ".join(' = ?,',$elements)." = ? where id = ".$id);
  			  			$stmt->execute($element_values);
						if($stmt->rowCount()>0){
							$status = TRUE;
						}else{
							$status = FALSE;
						}
					}
					else
					{
				
						  $stmt = $conn->prepare("insert into ".$this->tblProduct."(".join(',',$elements).") values(".what(count($elements)).")");
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
	
		
	function SearchProduct($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.*,dATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date from ".$this->tblProduct." t inner join stha_users u on t.user_id = u.id where $search_string order by ordering desc $limit";			  			
					$result = $conn->query(trim($sql));
				    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
					
					while($data = $result->fetch())
					{
						$item[] = $data;
					}
				//	var_dump($item);
				}
			catch(Exception $e)
				{
				 	  //exception $e->getMessage()
				}
		return $item;
	}

	
	
	function FindProduct( $category="", $limit = null, $id = 0, $field='id',$order='desc',$language = 0)
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
						$sql = "select t.* from ".$this->tblProduct." t ".$where." order by $field $order $limit";
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
							$sql = "select t.* from ".$this->tblProduct." t ".$where." order by $field $order $limit";
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
	
	function DeleteProduct($id)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
					$product = $this->FindProduct("",null,$id);
					unlink("photo/".$product->product_image);
					unlink("photo/thumb/".$product->product_image);
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//echo "delete from ".$this->tblProduct." where id = ? limit 1";
					$stmt = $conn->prepare("delete from ".$this->tblProduct." where id = ? limit 1");
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
	
	function getProductByCategory($cat)
	{
		$where ="category_id='$cat' and publish='1'";
		return $this->SearchProduct($where);
	
	}
	
	// cart configuration
	function SaveConfig()
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("delete from ".$this->tblConfig);
		$stmt->execute();
		if($stmt->rowCount()>0)
		{
			foreach($this->_data as $key=>$val)
			{
				$elements[] = $key;
				$element_values[] = $val;
			}
			$conn->query("SET CHARACTER SET utf8");
			$conn->query("SET SESSION collation_connection='utf8_general_ci'");
		
			$stmt = $conn->prepare("insert into ".$this->tblConfig."(".join(',',$elements).") values(".what(count($elements)).")");
			$stmt->execute($element_values);
			if($stmt->rowCount()>0){
				  $status = TRUE;
			  }else{
				  $status = FALSE;
		  }
		}else{
			$status = FALSE;
		}
	return $status;
	
	}
	
	function getConfig()
	{
	global $CONN_STRING,$USER_NAME,$PWD;
		try{
			  $conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
			  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			  $conn->query("SET CHARACTER SET utf8");
			  $conn->query("SET SESSION collation_connection='utf8_general_ci'");
			  $sql = "select t.* from ".$this->tblConfig." as t";
			  $result = $conn->query(trim($sql));
			  $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
			  $data = $result->fetch();
		}
		catch(Exception $e)
		{
			  //print $e->getMessage();
		}
		return $data;
	}
}
?>