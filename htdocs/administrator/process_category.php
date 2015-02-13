<?php
	//authorize the user and then allow the method
   include('includes/_session.php');
   include_once('helpers/class.category.php');
   include_once('helpers/utility_functions.php');
   $data = $_POST['data']['Category'];
   $action = $_REQUEST['action'];
   include('includes/_filter.php');
   switch($action)
   {
   		case 'add':
				  if( validate( $data, array( array('name'=>'category_name','type'=>'string'), array('name'=>'category_unique_name','type'=>'string') ) ) )
				  {
				  	$category = new Category($data);
					if($category->Save())
					{
						header("Location: add_category.php?status=success");
					}
					else
					{
						header("Location: add_category.php?status=failed");
					}
				  }
				  else
				  {
				  	header("Location: add_category.php?status=invalid");
				  }
				  break;
		case 'update':
				  if( validate( $data, array( array('name'=>'category_name','type'=>'string'), array('name'=>'category_unique_name','type'=>'string') ) ) )
				  {
				  	$category = new Category($data);
					if($category->Save($_POST['category']))
					{
						header("Location: categories.php?status=u-success");
					}
					else
					{
						header("Location: categories.php?status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: categories.php?status=invalid");
				  }
				  break;
		case 'delete':
					if(intval($_GET['category'])){
						$category = new Category();
						if($category->Delete($_GET['category']))
						{
							header("Location: categories.php?status=d-success");
						}
						else
						{
							header("Location: categories.php?status=d-failed");
						}
					}
					else{
						header("Location: categories.php?status=invalid");
					}
					break;
   }

?>