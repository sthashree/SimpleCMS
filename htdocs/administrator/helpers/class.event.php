<?php
include_once('class.dbobject.php');
class Event extends DBObject  {
	var $uses = "stha_event";
	var $_files;
	var $_data;
	function __construct($data='',$file='')
	{
		parent::__construct($data,$this->uses);
		$this->_files = $file;
		$this->_data = $data;
	}
	
	function getHours($type,$hour) {
		$hours=array();
		for($i=1;$i<25;$i++)
		{
			$hours[]=$i;
		}
		echo $this->SelectTime('data['.$type.'][hour]',$hours,$hour,'','00');
	}
	
	function getMinutes($type,$hour) {
		$hours=array();
		for($i=1;$i<61;$i++)
		{
			$hours[]=$i;
		}
		echo $this->SelectTime('data['.$type.'][minute]',$hours,$hour,'','00');
	}
	
	function SelectTime($name,$datas,$value='',$func='',$select='')
	{
		global $db;
		if($select=="") $select ="Select One";
		if($func!=""){ $change="onChange='$func'";}
		$return="<select name=".$name." id=".$name." ". $change.">";
		$return.="<option value=0> ".$select ." </option>";
		if(is_array($datas)) {
			foreach($datas as $data)
			{
				if($data<10) $data = "0".$data;
				$return.="<option value='".$data."'";
				if($data==$value) { $return.="selected='selected'";  }
			 	$return.=">".$data."</option>";
			}
		}	
		$return.="</select>";
		return $return;
		
	}
	
	
	function Save($id = 0)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		include("class.imageupload.php");
		$imageUpload = new ImageUpload($this->_files,1);    //first Parameter file 2nd parameter for thumbnail. 0 for no thumbnail and 1 for thumbnail
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
				if(is_array($val))
				{
				$elements[]=$key;
					foreach($val as $lankey => $lanval)
					{
						$lastlanval[$key].="[".$lankey."]".$lanval."[/".$lankey."]";	
					}
					
				 $element_values[] = $lastlanval[$key];
				//echo getLanguageSpecific($lastlanval[$key],"en");
				}
				else {
					$elements[] = $key;
					$element_values[] = $val;
				}
			}
			//var_dump($elements);
			//die;
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
					$sql = "select max(t.ordering) as orderi from $this->_uses as t";			  			
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
		
	//	die;
		return $status;
	}

	
	
	
	function getForFeed()
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.* from $this->_uses as t where t.published='1' and ispublic='1' order by id desc $limit";			  			
					$result = $conn->query(trim($sql));
				    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
					$i=0;
					while($data = $result->fetch())
					{
						$item[$i]["title"] = $data->title;
						$item[$i]["description"] = $data->description."<p>Start Time:".$data->start_time."</p><p> End Time :".$data->end_time."</p>";
						$item[$i]["pubDate"] = $data->updated_date;
						$item[$i]["image"] = $data->image;
					$i++;
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
					echo $sql = "select t.id,t.title,t.description,t.start_time,t.end_time,dATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,t.short_description,u.username,match(t.title,t.short_description,t.description) against ('$search_string' IN BOOLEAN MODE) as relevancy from $this->_uses t inner join stha_users u on t.user_id = u.id where match(t.title,t.short_description,t.description) against ('$search_string' IN BOOLEAN MODE) order by relevancy desc $limit";			  			
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
						$sql = "select t.*,DATE_FORMAT(t.start_time,'%Y-%m-%d') from ".$this->_uses." t where t.id = ".$id." order by $field $order $limit";
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