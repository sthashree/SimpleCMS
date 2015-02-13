<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.usertype.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['User'];
   
   $roles = $_POST['data']['Role'];
   $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   $data = trim_array($data);
   include('../includes/_filter.php');
   switch($action)
   {
   		
		
		case 'addusertype':
				  if( validate( $data, array(array('name'=>'type','type'=>'string') ) ) )
				  {
				  	$usertype = new Usertype($data,$roles);
				  	if($usertype->Save())
					{
						header("Location: ../user.php?extra=addusertype&status=success");
					}
					else
					{
						header("Location: ../user.php?extra=addusertype&status=status=failed");
					}
				  }
				  else
				  {
				  	
				  	header("Location: ../user.php?extra=addusertype&status=invalid");
				  }
				  break;
		case 'editusertype':
					if( validate( $data, array(array('name'=>'type','type'=>'string') ) ) )
				  {
				  	$usertype = new UserType($data,$roles);
				  	
					if($usertype->Save(makeClean($_POST['id'])))
					{
						header("Location: ../user.php?extra=usertype&status=u-success");
					}
					else
					{
						header("Location: ../user.php?extra=usertype&status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: ../user.php?extra=usertype&status=invalid");
				  }
				  break;
				  
		case 'delete':
					if(intval($_GET['type'])){
						$usertype = new Usertype($data,$file);
						if($usertype->Delete(makeClean($_GET['type'])))
						{
							header("Location: ../user.php?extra=usertype&status=d-success");
						}
						else
						{
							header("Location: ../user.php?extra=usertype&status=d-failed");
						}
					}
					else{
						header("Location: ../user.php?extra=usertype&status=invalid");
					}
					break;
					
		   }

?>