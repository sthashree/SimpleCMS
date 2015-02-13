<?php
include_once('class.dbobject.php');
class Cart extends DBObject  {
	var $tblCart = "stha_shopping_cart";
	var $uses = "stha_prod_cart";
	var $tblProduct ="stha_product";
	var $tblCategory ="stha_product_category";
	var $tblDelivery ="stha_delivery_address";
	var $_files;
	var $_data;
	function __construct($data='',$file='')
	{
		parent::__construct($data,$this->uses);
		$this->_files = $file;
		$this->_data = $data;
	}
	
	function incompleteCartExists($user_id) {
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
				$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$conn->query("SET CHARACTER SET utf8");
				$conn->query("SET SESSION collation_connection='utf8_general_ci'");
				$sql = "select * from ".$this->tblCart." where user_id='$user_id' and confirmed=0" ;
				$result=$conn->query($sql);
				$result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
				if($result->columnCount()>0)
				{
					$values = $result->fetch();	
					$status = $values;
				}
		
		}
		catch(Exception $e)
		{
			//  print $e->getMessage();
		}

		return $status;
	}
	
	function createCart($info,$id='') {
		//var_dump($info);
		global $CONN_STRING,$USER_NAME,$PWD;
		$status = FALSE;
		if(is_array($info))
		{
			foreach($info as $key=>$val)
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
						
						$stmt = $conn->prepare("update ".$this->tblCart." set ".join(' = ?,',$elements)." = ? where id = ".$id);
  			  			$stmt->execute($element_values);
						if($stmt->rowCount()>0){
							$status = $id;
						}else{
							$status = FALSE;
						}
					}
					else
					{
				
						  $stmt = $conn->prepare("insert into ".$this->tblCart."(".join(',',$elements).") values(".what(count($elements)).")");
						  $stmt->execute($element_values);
						  if($stmt->rowCount()>0){
							  $status = $conn->lastInsertId();
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
	
	function Save($data,$id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		$status = FALSE;
		//var_dump($data);
		//die;
		if(is_array($data))
		{
			$result = $this->FindProduct($data['prod_id']);
			if(count($result)>0) {
				$id=$result->id;
				$available_prods=$result->quantity;
			}
			foreach($data as $key=>$val)
			{
				$elements[] = $key;
				if($key=="quantity") { $val+=$available_prods; }
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
					$sql = "select t.*,u.* from $this->tblCart t inner join stha_users u on t.user_id = u.id where $search_string order by ordered_date desc $limit";			  			
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
	
	function Find( $limit = null, $id = 0, $field='id',$order='desc',$language = 0)
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
					$stmt = $conn->prepare("start transaction");
					$stmt = $conn->prepare("delete from ".$this->tblCart." where id = ? limit 1");
					$stmt->execute(array($id));
					if($stmt->rowCount()>0){
						$stmt = $conn->prepare("delete from ".$this->_uses." where cart_id = ?");
						$stmt->execute(array($id));
						if($stmt->rowCount()>0){
						$stmt = $conn->prepare("commit");
							$status = TRUE;
						}else{
							
						$stmt = $conn->prepare("rollback");
							$status = FALSE;
						}
					}
				}
			catch(Exception $e)
				{
				 	  //print $e->getMessage();
				}
		}
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
					$sql = "select t.*,dATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date from ".$this->_uses." t inner join stha_users u on t.user_id = u.id inner join stha_product p on p.id=t.prod_id inner join ".$this->tblCart." as c on c.id = t.cart_id   where c.user_id ='$user_id' order by ordering desc $limit";			  			
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

	
	
	function FindProduct($id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($id!="") $where .= " where prod_id='$id'";
					if(intval($id) > 0)
					{
						$sql = "select t.* from ".$this->_uses." t ".$where;
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$item = $result->fetch();
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
	
	function getProductByUser($user_id,$confirmed=0,$limit="")
	{
	global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.*,p.product_title as productname,p.id as pid,u.*,p.*,t.cart_id as cartId from ".$this->_uses." t inner join stha_product p on p.id=t.prod_id inner join ".$this->tblCart." as c on c.id = t.cart_id inner join stha_users u on c.user_id = u.id where c.user_id ='$user_id' and c.confirmed = ".$confirmed." order by ordering desc $limit";			  			
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
	
	function getProductByCart($cart_id,$confirmed=0,$limit="")
	{
	global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.*,p.product_title as productname,p.id as pid,u.*,p.*,t.cart_id as cartId from ".$this->_uses." t inner join stha_product p on p.id=t.prod_id inner join ".$this->tblCart." as c on c.id = t.cart_id inner join stha_users u on c.user_id = u.id where c.id ='$cart_id' and c.confirmed = ".$confirmed." order by ordering desc $limit";			  			
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
	
	function SaveDelivery($user_id) {
		
		global $CONN_STRING,$USER_NAME,$PWD;
		$status = FALSE;
		var_dump($this->_data);
		//die;
		if(is_array($this->_data))
		{
			$result = $this->FindDeliveryAddress($user_id);
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
					$result = $this->FindDeliveryAddress($user_id);
					if(count($result)>0) {
						$stmt = $conn->prepare("update ".$this->tblDelivery." set ".join(' = ?,',$elements)." = ? where user_id = ".$user_id);
  			  			$stmt->execute($element_values);
						if($stmt->rowCount()>0){
							$status = TRUE;
						}else{
							$status = TRUE;
						}
					}
					else
					{
						$elements[]='user_id';
						$element_values[]=$user_id;
						//echo "insert into ".$this->tblDelivery."(".join(',',$elements).") values(".what(count($elements)).")";	
						  $stmt = $conn->prepare("insert into ".$this->tblDelivery."(".join(',',$elements).") values(".what(count($elements)).")");
						  
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
	
	
	function FindDeliveryAddress($user_id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($user_id!="") $where .= " where user_id='$user_id'";
					if(intval($user_id) > 0)
					{
						$sql = "select t.* from ".$this->tblDelivery." t ".$where;
						$result = $conn->query(trim($sql));
					    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
						$item = $result->fetch();
					}
				}
			catch(Exception $e)
				{
				 	  //exception $e->getMessage();
				}
		return $item;
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
	function DeleteItem($cart_id,$prodId) {
		try{
	global $CONN_STRING,$USER_NAME,$PWD;
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//echo "delete from ".$this->_uses." where prod_id = '$prodId' and cart_id ='$cart_id' limit 1";
					$stmt = $conn->query("delete from ".$this->_uses." where prod_id = '$prodId' and cart_id ='$cart_id' limit 1");
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
		
		return $status;
	}
		/*function UpdateItem($cart_id,$prodId,$quantity) {
			echo $quantity;
		try{
				$elements[] = "quantity";
				echo $element_values[] = mysql_real_escape_string($quantity);
	global $CONN_STRING,$USER_NAME,$PWD;
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//	$stmt = $conn->prepare("update ".$this->tblCart." set ".join(' = ?,',$elements)." = ? where id = ".$id)
					$stmt = $conn->prepare("update ".$this->_uses." set ".join(' = ?,',$elements)." = ? where prod_id = '$prodId' and cart_id ='$cart_id' limit 1");
					$stmt->execute($element_values);
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
		
		return $status;
	}*/
		
		function UpdateItem($cart_id,$prodId,$quantity) {
		try{
	global $CONN_STRING,$USER_NAME,$PWD;
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//echo "quantiry$quantity";
					//echo "update ".$this->_uses." set quantity = '".$quantity."' where prod_id = '$prodId' and cart_id ='$cart_id' limit 1";
					$stmt = $conn->query("update ".$this->_uses." set quantity = '".mysql_escape_string($quantity)."' where prod_id = '$prodId' and cart_id ='$cart_id' limit 1");
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
				//die;
		
		return $status;
	}
	
	function updateDeleveredCart($cart_id) {
		try{
				global $CONN_STRING,$USER_NAME,$PWD;
				$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				//echo "quantiry$quantity";
				//echo "update ".$this->_uses." set quantity = '".$quantity."' where prod_id = '$prodId' and cart_id ='$cart_id' limit 1";
				$stmt = $conn->query("update ".$this->tblCart." set delivered = 1 id ='$cart_id' limit 0,1");
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
			//die;
		
		return $status;
		
	}
	
	function updateConfirmCart($cart_id,$state=1) {
		try{
				$status=FALSE;
				global $CONN_STRING,$USER_NAME,$PWD;
				$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				//echo "quantiry$quantity";
				//echo "update ".$this->tblCart." set confirmed = '".$state."' where id ='$cart_id' limit 0,1";
				$stmt = $conn->query("update ".$this->tblCart." set confirmed = '".$state."' where id ='$cart_id' limit 1");
				
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
			//die;
		
		return $status;
		
	}
	
	function getConfirmedCart($confirm=1) {
		$confirmedCart = $this->Search("confirmed = '".$confirm."'");
	//	var_dump($confirmedCart);
		return $confirmedCart;
	}
	function delivered($id,$stat)
	{
		$status = FALSE;
		global $CONN_STRING,$USER_NAME,$PWD;
		if(intval($id)>0)
		{
			try{
		//	echo $id;
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					//echo "update ".$this->tblCart." set delivered='$stat' where id = ?";
					$stmt = $conn->prepare("update ".$this->tblCart." set delivered='$stat' where id = ?");
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
	
}
?>