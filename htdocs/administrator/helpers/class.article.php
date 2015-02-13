<?php
include_once('class.dbobject.php');
class Article extends DBObject  {
	var $uses = "articles";

	function __construct($data=null)
	{
		parent::__construct($data,$this->uses);
	}
	
	function Search($search_string,$limit=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					echo $sql = "select t.id,t.title,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,t.short_description,u.username,match(t.title,t.keywords,t.full_description) against ('$search_string' IN BOOLEAN MODE) as relevancy from $this->_uses t inner join stha_users u on t.user_id = u.id where match(t.title,t.keywords,t.full_description) against ('$search_string' IN BOOLEAN MODE) order by relevancy desc $limit";			  			
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
	
	function getHomepageObjects($limit=null,$lang = 'np')
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.* from ".$this->_uses." t inner join languages l on t.language_id = l.id where t.homepage = 1 and t.published = 1 and l.abbr = '$lang' order by t.id $limit";
					//print $sql;	  			
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
	
	function Find($category=0, $limit = null, $id = 0, $field='id',$order='desc',$language = 0)
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
						if($category>0)
						{
							$where = "t.category_id = $category";
							if($language > 0)
							{
								$where .= " and t.language_id = $language";
							}
							$sql = "select t.title,t.id,t.published,t.homepage,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,c.category_name,u.username,l.language from ".$this->_uses." t inner join categories c on t.category_id = c.id inner join stha_users u on t.user_id = u.id left join languages l on t.language_id = l.id where $where order by $field $order $limit";
						}
						else
						{
							if($language > 0)
							{
								$where .= "where t.language_id = $language";
							}
							$sql = "select t.title,t.id,t.published,t.homepage,DATE_FORMAT(t.modified_date,'%Y-%m-%d') as modified_date,c.category_name,u.username,l.language from ".$this->_uses." t inner join categories c on t.category_id = c.id inner join stha_users u on t.user_id = u.id left join languages l on t.language_id = l.id  $where order by $field $order $limit";
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
	function getArticles($lang = 'jp',$category_name, $limit = null, $field='id',$order='desc',$excluded_category_name=null)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					if($category_name=='all'){
						$sql = "select t.title,t.id,t.published,t.homepage,DATE_FORMAT(t.modified_date,'%d.%m.%Y') as modified_date,c.category_name,u.username, t. full_description,t.short_description,t.hits from ".$this->_uses." t inner join categories c on t.category_id = c.id inner join stha_users u on t.user_id = u.id inner join languages l on t.language_id = l.id where c.category_unique_name <> '$excluded_category_name' and t.published = 1 and l.abbr = '$lang' order by $field $order $limit";
					}else{
						$sql = "select t.title,t.id,t.published,t.homepage,DATE_FORMAT(t.modified_date,'%d.%m.%Y') as modified_date,c.category_name,u.username,t. full_description,t.short_description,t.hits from ".$this->_uses." t inner join categories c on t.category_id = c.id inner join stha_users u on t.user_id = u.id inner join languages l on t.language_id = l.id where c.category_unique_name = '$category_name' and t.published = 1 and l.abbr = '$lang' order by $field $order $limit";
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
				 	  //exception $e->getMessage()
				}
		return $item;
	}
	
	function getArticleByKeyword($searchString)
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
						$sql = "select t.* from ".$this->_uses." t  where $searchString and t.published = 1 limit 0,1";
					
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