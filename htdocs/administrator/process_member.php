<?php
	//authorize the user and then allow the method
   include('includes/_session.php');
   include_once(ADMINPATH.'/helpers/class.member.php');
   include_once(ADMINPATH.'/helpers/utility_functions.php');
   $data = $_POST['data']['Member'];
   $file = $_FILES['photo'];
   $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   $data = trim_array($data);
   include('includes/_filter.php');
   switch($action)
   {
   		case 'add':
				  if( validate( $data, array(array('name'=>'firstname','type'=>'string'), array('name'=>'lastname','type'=>'string'), array('name'=>'keywords','type'=>'string'), array('name'=>'short_description','type'=>'string'), array('name'=>'full_description','type'=>'string') ) ) )
				  {
				  	$member = new Member($data,$file);
				  	
					if($member->Save())
					{
						header("Location: add_member.php?status=success");
					}
					else
					{
						header("Location: add_member.php?status=failed");
					}
				  }
				  else
				  {
				  	header("Location: add_member.php?status=invalid");
				  }
				  break;
		case 'update':
					if( validate( $data, array(array('name'=>'firstname','type'=>'string'), array('name'=>'lastname','type'=>'string'), array('name'=>'keywords','type'=>'string'), array('name'=>'short_description','type'=>'string'), array('name'=>'full_description','type'=>'string') ) ) )
				  {
				  	$member = new Member($data,$file);
					if($member->Save($_POST['member']))
					{
						header("Location: members.php?status=u-success");
					}
					else
					{
						header("Location: members.php?status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: members.php?status=invalid");
				  }
				  break;
		case 'delete':
					if(intval($_GET['member'])){
						$member = new Member($data,$file);
						if($member->Delete($_GET['member']))
						{
							header("Location: members.php?status=d-success");
						}
						else
						{
							header("Location: members.php?status=d-failed");
						}
					}
					else{
						header("Location: members.php?status=invalid");
					}
					break;
   }

?>