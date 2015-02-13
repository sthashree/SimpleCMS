<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.product.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['product'];
   //var_dump($data);
   $file = $_FILES['photo'];
  $category=$_POST['category'];
  $subcategory=$_POST['subcategory'];
  
  $data['category_id']=$subcategory;
 
  if($data['category_id']=="" ) {
  $data['category_id']=$category;
  }
  // die;
   $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   $data = trim_array($data);
   include('../includes/_filter.php');
   switch($action)
   {
   		
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
				  	die;
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
				  
		case 'deleteProduct':
					if(intval($_GET['product'])){
						$productObj = new Product($data,$file);
						if($productObj->DeleteProduct($_GET['product']))
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