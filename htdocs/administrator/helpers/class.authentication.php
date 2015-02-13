<?php
include_once('config.php');
class Authentication 
{
	function authenticate($u,$p)
	{
		$status = array('id'=>-1,'status'=>FALSE);
		global $CONN_STRING,$USER_NAME,$PWD;
		try
		{
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$stmt = $conn->prepare("select id from stha_users where username = ? and password = ? and active > 0 limit 0,1");
			  		$stmt->execute(array($u,$p));
					$user = $stmt->fetch(PDO::FETCH_OBJ);
					if($stmt->rowCount()>0){
						$status = array('id'=>$user->id,'status'=>TRUE);
					}else{
						$status = array('id'=>-1,'status'=>FALSE);
					}
		}
		catch(Exception $e)
		{
				 	  //print $e->getMessage();
		}
		return $status;
	}
}
?>