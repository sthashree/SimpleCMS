<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.gallery.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data'];
   //var_dump($data);
   $action = $_REQUEST['action'];
   //$data[1]['user_id'] = base64_decode($_SESSION['user_id']);
   //$data = trim_array($data);
   include('../includes/_filter.php');
   switch($action)
   {
   		case 'configure':
				
				  	$gallery = new Gallery($data);
				  	
					if($gallery->SaveConfig($_POST['id']))
					{
						header("Location: ../gallery.php?extra=configure&status=u-success");
					}
					else
					{
						header("Location: ../gallery.php?extra=configure&status=u-failed");
					}
				  break;
			
   			
   		case 'finalphoto':
				
				  	$gallery = new Gallery($data,$file);
					
					if($gallery->SavePhoto())
					{
						header("Location: ../gallery.php?extra=viewphoto&status=u-success");
					}
					else
					{
						header("Location: ../gallery.php?extra=viewphoto&status=u-failed");
					}
				  
				  break;
				  
		case 'delete':
					if(intval($_GET['photo'])){
						$gallery = new Gallery($data,$file);
						if($gallery->DeletePhoto($_GET['photo']))
						{
							header("Location: ../gallery.php?extra=viewphoto&status=d-success");
						}
						else
						{
							header("Location: ../gallery.php?extra=viewphoto&status=d-failed");
						}
					}
					else{
						header("Location: ../gallery.php?extra=viewphoto&status=invalid");
					}
					break;
		
			
   }

?>