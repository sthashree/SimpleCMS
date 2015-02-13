<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.gallery.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['Gallery'];
   //var_dump($data);
   $file = $_FILES['logo'];
   echo $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   $data = trim_array($data);
   include('../includes/_filter.php');
   switch($action)
   {
   		
		
		case 'addgallery':
				  if( validate( $data, array(array('name'=>'gallery_name','type'=>'string') ) ) )
				  {
				  	$gallery = new Gallery($data,$file);
				  	if($gallery->Save())
					{
						header("Location: ../gallery.php?extra=addgallery&status=success");
					}
					else
					{
						header("Location: ../gallery.php?extra=addgallery&status=status=failed");
					}
				  }
				  else
				  {
				  	
				  	header("Location: ../gallery.php?extra=addgallery&status=invalid");
				  }
				  break;
		case 'editgallery':
					if( validate( $data, array(array('name'=>'gallery_name','type'=>'string') ) ) )
				  {
				  	$gallery = new Gallery($data,$file);
				  	
					if($gallery->Save($_POST['id']))
					{
						header("Location: ../gallery.php?extra=viewgallery&status=u-success");
					}
					else
					{
						header("Location: ../gallery.php?extra=viewgallery&status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: ../gallery.php?extra=viewgallery&status=invalid");
				  }
				  break;
				  
		case 'delete':
					if(intval($_GET['gallery'])){
						$gallery = new Gallery($data,$file);
						if($gallery->Delete($_GET['gallery']))
						{
							header("Location: ../gallery.php?extra=viewgallery&status=d-success");
						}
						else
						{
							header("Location: ../gallery.php?extra=viewgallery&status=d-failed");
						}
					}
					else{
						header("Location: ../gallery.php?extra=viewgallery&status=invalid");
					}
					break;
					
		
		case 'finalphoto':
					
				  	$gallery = new Gallery($data,$file);
				  	
					if($gallery->SavePhoto($_POST))
					{
						header("Location: ../gallery.php?extra=viewphoto&status=u-success");
					}
					else
					{
						header("Location: ../gallery.php?extra=viewphoto&status=u-failed");
					}
				  
				  break;
   }

?>