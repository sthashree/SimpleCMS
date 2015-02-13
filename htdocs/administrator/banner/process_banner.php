<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.banner.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['banner'];
   $file = $_FILES['photo'];
   $action = $_REQUEST['action'];
   
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   include('../includes/_filter.php');
   switch($action)
   {
   		case 'add':
				 // if( validate( $data, array(array('name'=>'title','type'=>'string') ) ) )
				  {
				
				  	$banner = new Banner($data,$file);
				  	
					if($banner->Save())
					{
						header("Location: ../banner.php?extra=add_banner&status=success");
					}
					else
					{
						header("Location: ../banner.php?extra=add_banner&status=failed");
					}
				  }
				 // else
				  //{
				  	//header("Location: ../banner.php?extra=add_banner&status=invalid");
				  //}
				  break;
		case 'update':
					//if( validate( $data, array(array('name'=>'title','type'=>'string') ) ) )
				  {
				  	$banner = new Banner($data,$file);
					if($banner->Save($_POST['banner']))
					{
						header("Location: ../banner.php?extra=banners&status=u-success");
					}
					else
					{
						header("Location: ../banner.php?extra=banners&status=u-failed");
					}
				  }
				  //else
				  //{
				  	//header("Location: ../banner.php?extra=banners&status=invalid");
				 // }
				  break;
		case 'saveorder':
					//if( validate( $data, array(array('name'=>'title','type'=>'string') ) ) )
					
				  {
				  	$banner = new Banner();
					if($banner->saveorder($_POST['order']))
					{
						header("Location: ../banner.php?extra=banners&status=u-success");
					}
					else
					{
							//die;
						header("Location: ../banner.php?extra=banners&status=u-failed");
					}
				  }
				  //else
				  //{
				  	//header("Location: ../banner.php?extra=banners&status=invalid");
				 // }
				  break;				  
		case 'delete':
					if(intval($_GET['banner'])){
						$banner = new Banner($data,$file);
						if($banner->Delete($_GET['banner']))
						{
							header("Location: ../banner.php?extra=banners&status=d-success");
						}
						else
						{
							header("Location: ../banner.php?extra=banners&status=d-failed");
						}
					}
					else{
						header("Location: ../banner.php?extra=banners&status=invalid");
					}
					break;
   }

?>