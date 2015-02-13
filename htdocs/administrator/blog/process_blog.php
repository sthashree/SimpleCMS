<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.blog.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['Blog'];
   //var_dump($data);
   echo $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   $data = trim_array($data);
   include('../includes/_filter.php');
  
   switch($action)
   {
   		
		
		case 'addcategory':
				  if( validate( $data, array(array('name'=>'category_name','type'=>'string') ) ) )
				  {
				  	$objBlog = new Blog($data);
				  	if($objBlog->Save())
					{
						header("Location: ../blog.php?extra=addcategory&status=success");
					}
					else
					{
						header("Location: ../blog.php?extra=addcategory&status=status=failed");
					}
				  }
				  else
				  {
				  	
				  	header("Location: ../blog.php?extra=addcategory&status=invalid");
				  }
				  break;
		case 'editcategory':
					if( validate( $data, array(array('name'=>'category_name','type'=>'string') ) ) )
				  {
				  	$objBlog = new Blog($data);
				  	
					if($objBlog->Save($_POST['id']))
					{
						header("Location: ../blog.php?extra=viewcategory&status=u-success");
					}
					else
					{
						header("Location: ../blog.php?extra=viewcategory&status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: ../blog.php?extra=viewcategory&status=invalid");
				  }
				  break;
				  
		case 'delete':
					if(intval($_GET['blog'])){
						$objBlog = new Blog($data,$file);
						if($objBlog->Delete($_GET['blog']))
						{
							header("Location: ../blog.php?extra=viewcategory&status=d-success");
						}
						else
						{
							header("Location: ../blog.php?extra=viewcategory&status=d-failed");
						}
					}
					else{
						header("Location: ../blog.php?extra=viewcategory&status=invalid");
					}
					break;
					
		
   }

?>