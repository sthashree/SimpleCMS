<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.event.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['event'];
   $file = $_FILES['photo'];
   $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
     	$data[start_time] = setTime($_POST['data']['start_date']);
  		$data[end_time] = setTime($_POST['data']['end_date']);
 // $data = trim_array($data);
//  var_dump($_POST['data']['start_date']);
//var_dump($data);
//die;
   include('../includes/_filter.php');
   switch($action)
   {
   		case 'add':
				 // if( validate( $data, array(array('name'=>'title','type'=>'string') ) ) )
				  {
				
				  	$event = new Event($data,$file);
				  	
					if($event->Save())
					{
						header("Location: ../event.php?extra=add_event&status=success");
					}
					else
					{
						header("Location: ../event.php?extra=add_event&status=failed");
					}
				  }
				 // else
				  //{
				  	//header("Location: ../event.php?extra=add_event&status=invalid");
				  //}
				  break;
		case 'update':
					//if( validate( $data, array(array('name'=>'title','type'=>'string') ) ) )
				  {
				  	$event = new Event($data,$file);
					if($event->Save($_POST['event']))
					{
						header("Location: ../event.php?extra=events&status=u-success");
					}
					else
					{
						header("Location: ../event.php?extra=events&status=u-failed");
					}
				  }
				  //else
				  //{
				  	//header("Location: ../event.php?extra=events&status=invalid");
				 // }
				  break;
		case 'delete':
					if(intval($_GET['event'])){
						$event = new Event($data,$file);
						if($event->Delete($_GET['event']))
						{
							header("Location: ../event.php?extra=events&status=d-success");
						}
						else
						{
							header("Location: ../event.php?extra=events&status=d-failed");
						}
					}
					else{
						header("Location: ../event.php?extra=events&status=invalid");
					}
					break;
   }

?>