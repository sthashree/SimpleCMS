<?php
	//session_start();
	require_once('../includes/_init.php'); 
	require_once(ADMINPATH.'/helpers/class.product.php');
	require_once(ADMINPATH.'/helpers/utility_functions.php');
	$productObj = new Product();
	$cat=$_POST['id'];
	$categories = $productObj->Find($cat);
	if(count($categories)>0) {
		$subcategories.="<label for=\"title\" class=\"required\">". $t->translate('myproduct/subcategory')."</label>"; 
		$subcategories.=SelectList("subcategory",$categories,"category_name");
		$subcategories.="<br />";
	}
	echo $subcategories;
	?>

