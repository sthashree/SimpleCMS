<?php
	//authorize the user and then allow the method
   include('includes/_session.php');
   require_once('includes/_init.php'); 
   include_once(ADMINPATH.'/helpers/class.menu.php');
   include_once(ADMINPATH.'/helpers/utility_functions.php');
   $data = $_POST['data']['Menu'];
   $action = $_REQUEST['action'];
   include('includes/_filter.php');
   switch($action)
   {
   		case 'add':
				  if( validate( $data, array( array('name'=>'menu_name','type'=>'string'), array('name'=>'menu_unique_name','type'=>'string'), array('name'=>'position','type'=>'numeric') ) ) )
				  {
				  	$menu = new Menu($data);
					if($menu->Save())
					{
						header("Location: add_menu.php?status=success");
					}
					else
					{
						header("Location: add_menu.php?status=failed");
					}
				  }
				  else
				  {
				  	header("Location: add_menu.php?status=invalid-data");
				  }
				  break;
		case 'update':
			
				  if( validate( $data, array( array('name'=>'menu_name','type'=>'string'), array('name'=>'menu_unique_name','type'=>'string'), array('name'=>'position','type'=>'numeric') ) ) )
				  {
				  	$menu = new Menu($data);
					if($menu->Save($_POST['menu']))
					{
						header("Location: menus.php?status=u-success");
					}
					else
					{
						header("Location: menus.php?status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: menus.php?status=invalid-data");
				  }
				  break;
		case 'delete':
					if(intval($_GET['menu'])){
						$menu = new Menu();
						if($menu->Delete($_GET['menu']))
						{
							header("Location: menus.php?status=d-success");
						}
						else
						{
							header("Location: menus.php?status=d-failed");
						}
					}
					else{
						header("Location: menus.php?status=invalid-data");
					}
					break;
   }

?>