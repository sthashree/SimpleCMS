<?php
   header("Cache-Control: no-cache");
   header("Pragma: nocache");
   include_once('helpers/class.authentication.php');
   include_once('helpers/utility_functions.php');

   $action = $_REQUEST['action'];
   switch($action)
   {
   		case 'login':
				  $data = $_POST['data']['User'];
				  $data['enc-password'] = md5($data['password']);
				  if( validate( $data, array( array('name'=>'username','type'=>'string'), array('name'=>'password','type'=>'string') ) ) )
				  {
				  	$auth = new Authentication();
					$authorization = $auth->authenticate($data['username'],$data['enc-password']);
					if( $authorization['status'] == TRUE )
					{
						@session_name('session_admin');
						@session_start();
						$_SESSION['user_id'] = base64_encode($authorization['id']);
						$_SESSION['username'] = $data['username'];
						header("Location: index.php");
					}
					else
					{
						header("Location: login.php?status=failed");
					}
				  }
				  else
				  {
				  	header("Location: login.php?status=empty-fields");
				  }
				  break;
		case 'logout':
				  @session_name('session_admin');
				  @session_start();
				  @session_destroy();
				  header("Location: login.php?status=logged-out");
				  break;
   }
?>