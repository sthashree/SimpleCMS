<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.product.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['Category'];
   //var_dump($data);
  // $file = $_FILES['logo'];
   echo $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   $data = trim_array($data);
   include('../includes/_filter.php');
   switch($action)
   {
   		
		case 'addcategory':
				  if( validate( $data, array(array('name'=>'category_name','type'=>'string') ) ) )
				  {
				  	$productObj = new Product($data,$file);
				  	if($productObj->Save())
					{
						header("Location: ../product.php?extra=addcategory&status=success");
					}
					else
					{
						header("Location: ../product.php?extra=addcategory&status=status=failed");
					}
				  }
				  else
				  {
				  	
				  	header("Location: ../product.php?extra=addcategory&status=invalid");
				  }
				  break;
		case 'editcategory':
					if( validate( $data, array(array('name'=>'category_name','type'=>'string') ) ) )
				  {
				  	$productObj = new Product($data,$file);
				  	
					if($productObj->Save($_POST['id']))
					{
						header("Location: ../product.php?extra=viewcategory&status=u-success");
					}
					else
					{
						header("Location: ../product.php?extra=viewcategory&status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: ../product.php?extra=viewcategory&status=invalid");
				  }
				  break;
				  
		case 'deletecategory':
					if(intval($_GET['category'])){
						$productObj = new Product($data,$file);
						if($productObj->Delete($_GET['category']))
						{
							header("Location: ../product.php?extra=viewcategory&status=d-success");
						}
						else
						{
							header("Location: ../product.php?extra=viewcategory&status=d-failed");
						}
					}
					else{
						header("Location: ../product.php?extra=viewcategory&status=invalid");
					}
					break;
			
		
		case 'add':
				  if( validate( $data, array(array('name'=>'product_title','type'=>'string') ) ) )
				  {
				  	$productObj = new Product($data,$file);
				  	if($productObj->SaveProduct())
					{
						header("Location: ../product.php?extra=addproduct&status=success");
					}
					else
					{
						header("Location: ../product.php?extra=addproduct&status=status=failed");
					}
				  }
				  else
				  {
				  	
				  	header("Location: ../product.php?extra=addproduct&status=invalid");
				  }
				  break;
		case 'update':
					if( validate( $data, array(array('name'=>'product_title','type'=>'string') ) ) )
				  {
				  	$productObj = new Product($data,$file);
				  	
					if($productObj->SaveProduct($_POST['id']))
					{
						header("Location: ../product.php?extra=viewproduct&status=u-success");
					}
					else
					{
						header("Location: ../product.php?extra=viewproduct&status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: ../product.php?extra=viewproduct&status=invalid");
				  }
				  break;
				  
		case 'delete':
					if(intval($_GET['product'])){
						$productObj = new Product($data,$file);
						if($productObj->Delete($_GET['product']))
						{
							header("Location: ../product.php?extra=viewproduct&status=d-success");
						}
						else
						{
							header("Location: ../product.php?extra=viewproduct&status=d-failed");
						}
					}
					else{
						header("Location: ../product.php?extra=viewproduct&status=invalid");
					}
					break;
					
		
		
   }

?>