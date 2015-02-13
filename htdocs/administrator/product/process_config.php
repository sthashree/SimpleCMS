<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.product.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data']['product'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   $data = trim_array($data);
   include('../includes/_filter.php');
  $productObj = new Product($data);
	if($productObj->SaveConfig())
	{
		header("Location: ../product.php?extra=configure&status=success");
	}
	else
	{
		header("Location: ../product.php?extra=configure&status=failed");
	}
  
?>