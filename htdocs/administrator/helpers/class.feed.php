<?php
include_once('class.dbobject.php');

Class Feed extends DBObject {

	public function getProductFeed() {
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
			$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
			$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$conn->query("SET CHARACTER SET utf8");
			$conn->query("SET SESSION collation_connection='utf8_general_ci'");
			$sql = <<<SQL
				SELECT 
					sp.product_title,
					sp.product_price,
					sp.product_description,
					sp.product_image,
					spc.category_name,
					sc.commentor_name,
					sc.commentor_email,
					sc.comments
				FROM 
					stha_product as sp
				LEFT JOIN stha_product_category spc on spc.id = sp.category_id
				LEFT JOIN stha_comment sc on sc.product_id = sp.id
				WHERE 1

SQL;
			echo $sql;
			$result = $conn->query(trim($sql));
		    $result->setFetchMode(PDO::FETCH_CLASS,Stdclass);
			$item = $result->fetch();
			print_r($item);
		}
		catch (Exception $e) {

		}

	}

	function getEventFeed()
	{
		global $CONN_STRING,$USER_NAME,$PWD;
		try{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
					$sql = "select t.* from stha_event as t where t.published='1' and ispublic='1' order by id desc $limit";		  			
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
}

?>