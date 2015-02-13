<?php
include_once('class.dbobject.php');
class Chirasi extends DBObject  {
	var $uses = "stha_chirasi";
	var $_files;
	var $_data;
	function __construct($data='',$file='')
	{
		parent::__construct($data,$this->uses);
		$this->_files = $file;
		$this->_data = $data;
	//	var_dump($file);
	}
	
	function Search($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.id,t.photo,t.photo_description,t.chirasidate,t.front, DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date from ".$this->_uses." as t where ".$search_string." order by front desc $limit";			  			
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
	
	function Find($category=0, $limit = null, $id = 0, $field='t.id',$order='desc',$language = 0)
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
						$sql = "select t.*,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date from ".$this->_uses." t where final !=0 $where order by $field $order $limit";
							  			
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
	
	function Save($id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		$countPhoto = count($this->_data);
		if(is_array($this->_data))
		{
		for($i=1;$i<=$countPhoto;$i++)
		{
			$elements = array();
			$element_values = array();
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
				}
				else
				{
					$id = $val;
				}
			}
			if(is_array($this->_files)) {
				if($this->_files['name'][$i]['photo']!="") {
					$uploaddir = './uploads/'; 
					$ext=explode('.',$this->_files['name'][$i]['photo']);
					$ext=$ext[count($ext)-1];
					$new_name=time().".".$ext;
					$finalfile = $uploaddir. $new_name; 
					if(move_uploaded_file($this->_files['tmp_name'][$i]['photo'],$finalfile)) 
					{
						$elements[] = "photo";
						$element_values[] = $new_name;
					}
				}
			}
			try{
						
						echo $id;			
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
						$elements[]="final";
						$element_values[]="1";	
					//	$elements[]='photo';
						//$element_values[]=$name;
						echo "update ".$this->_uses." set ".join(' = ?,',$elements)." = ? where id = ".$id;	
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
		return $status;
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
					
					$photo = $this->Find(0,null,$id);
					unlink("uploads/".$member->photo);
				//	unlink("uploads/thumb/".$member->photo);

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
	
	function SearchFront($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select * from ".$this->_uses." as t  ".$search_string;			  			
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
	
}
?>