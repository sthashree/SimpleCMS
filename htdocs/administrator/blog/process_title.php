<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.blog.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['Blog'];
   //var_dump($data);
  $category=$_POST['category'];
  
  $data['category_id']=$category;
 
  // die;
   $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   $data = trim_array($data);
   include('../includes/_filter.php');
   switch($action)
   {
   		
		case 'addTitle':
				  if( validate( $data, array(array('name'=>'title','type'=>'string') ) ) )
				  {
				  	$objBlog = new Blog($data,$file);
				  	if($objBlog->SaveTitle())
					{
						header("Location: ../blog.php?extra=addtitle&status=success");
					}
					else
					{
						header("Location: ../blog.php?extra=addtitle&status=failed");
					}
				  }
				  else
				  {
				  	header("Location: ../blog.php?extra=addtitle&status=invalid");
				  }
				  break;
		case 'update':
					if( validate( $data, array(array('name'=>'title','type'=>'string') ) ) )
				  {
				  	$objBlog = new Blog($data,$file);
				  	
					if($objBlog->SaveTitle($_POST['id']))
					{
						header("Location: ../blog.php?extra=viewtitle&status=u-success");
					}
					else
					{
						header("Location: ../blog.php?extra=viewtitle&status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: ../blog.php?extra=viewtitle&status=invalid");
				  }
				  break;
				  
		case 'deleteTitle':
					if(intval($_GET['blog'])){
						$objBlog = new Blog($data,$file);
						if($objBlog->DeleteTitle($_GET['blog']))
						{
							header("Location: ../blog.php?extra=viewtitle&status=d-success");
						}
						else
						{
							header("Location: ../blog.php?extra=viewtitle&status=d-failed");
						}
					}
					else{
						header("Location: ../blog.php?extra=viewtitle&status=invalid");
					}
					break;
		
		case 'publish':
			if(intval($_GET['title'])>0){
						$objBlog = new Blog();
						echo $stat=1-$_GET['stat'];
						echo $_GET['title'];
						if($objBlog->PublishTitle($_GET['title'],$stat))
						{
							header("Location: ../blog.php?extra=viewtitle&status=p-success");
						}
						else
						{
							die;
							header("Location: ../blog.php?extra=viewtitle&status=p-failed");
						}
					}
					else{
						header("Location: ../blog.php?extra=viewtitle&status=invalid");
					}
					break;
					
		
		
   }

?>