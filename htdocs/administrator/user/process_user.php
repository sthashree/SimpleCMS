<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.users.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['Member'];
   $file = $_FILES['photo'];
   $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
  // $data = trim_array($data);
   include('../includes/_filter.php');
   switch($action)
   {
   		case 'add':
				  if( validate( $data, array(array('name'=>'firstname','type'=>'string'), array('name'=>'lastname','type'=>'string') ) ) )
				  {
				  	
						$member = new Users($data,$file);
						
				  	if($member->ValidUsername($_POST['data']['Member']['username']))
					{
						if($_POST['data']['Member']['password'] === $_POST['repassword'])
						{
							if($member->Save())
							{
								header("Location: ../user.php?extra=adduser&status=success");
							}
							else
							{
								die;
								header("Location: ../user.php?extra=adduser&status=failed");
							}
						}
						else {
							$_SESSION['user']=$data;
						header("Location: ../user.php?extra=adduser&status=pass");
						}

					  }
					else {
					$_SESSION['user']=$data;
						header("Location: ../user.php?extra=adduser&status=exists");
				  	}
				}
					  
				  else
				  {
				  	header("Location: ../user.php?extra=adduser&status=invalid");
				  }
				  break;
		case 'update':
					 if( validate( $data, array(array('name'=>'firstname','type'=>'string'), array('name'=>'lastname','type'=>'string') ) ) )
				  {
				  	$id=makeClean($_POST['id']);
						$member = new Users($data,$file);
						echo "$id";
						
				  	if($member->ValidUsername($_POST['data']['Member']['username'],$id))
					{
						if($_POST['data']['Member']['password'] === $_POST['repassword'])
						{
							if($member->Save($id))
							{
								header("Location: ../user.php?extra=user&status=u-success");
							}
							else
							{
								header("Location: ../user.php?extra=edituser&status=u-failed&id=$id");
							}
						  }
					}
					else
					{
							header("Location: ../user.php?extra=edituser&status=exists&id=$id");
				  	}
				}
				  else
				  {
				  	header("Location: ../user.php?extra=edituser&status=invalid&id=$id");
				  }
				  break;
		case 'delete':
					if(intval(makeClean($_GET['member']))){
						$member = new Users($data,$file);
						if($member->Delete(makeClean($_GET['member'])))
						{
							header("Location: ../user.php?extra=user&status=d-success");
						}
						else
						{
							header("Location: ../user.php?extra=user&status=d-failed");
						}
					}
					else{
						header("Location: ../user.php?extra=user&status=invalid");
					}
					break;
		case 'active':
					if(intval(makeClean($_GET['member']))){
						$member = new Users($data,$file);
						if($member->Activate(makeClean($_GET['member']),makeClean($_GET['state'])))
						{
							header("Location: ../user.php?extra=user&status=d-success");
						}
						else
						{
							header("Location: ../user.php?extra=user&status=d-failed");
						}
					}
					else{
						header("Location: ../user.php?extra=user&status=invalid");
					}
					break;			
   }

?>