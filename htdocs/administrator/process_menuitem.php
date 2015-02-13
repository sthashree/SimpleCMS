<?php
	//authorize the user and then allow the method
   include('includes/_session.php');
   include_once('/helpers/class.menuitem.php');
   include_once('/helpers/utility_functions.php');
   $data = $_POST['data']['MenuItem'];
   $action = $_REQUEST['action'];
   include('includes/_filter.php');
   switch($action)
   {
   		case 'add':
				  if( validate( $data, array( array('name'=>'menuitem_name','type'=>'string'), array('name'=>'mod_menu_id','type'=>'numeric') ) ) )
				  {
				  	$menuitem = new MenuItem($data);
					if($menuitem->Save())
					{
						header("Location: add_menuitem.php?menu=".$data['mod_menu_id']."&status=success");
					}
					else
					{
						header("Location: add_menu.php?menu=".$data['mod_menu_id']."&status=failed");
					}
				  }
				  else
				  {
				  	header("Location: add_menu.php?menu=".$data['mod_menu_id']."&status=invalid-data");
				  }
				  break;
		case 'update':
				  if( validate( $data, array( array('name'=>'menuitem_name','type'=>'string'), array('name'=>'mod_menu_id','type'=>'numeric') ) ) )
				  {
				  	$menuitem = new MenuItem($data);
					$childlist = $menuitem->getChildrens($_POST['menuitem']);
					if(is_array($childlist)){
						$blacklist =array_merge($childlist,array($_POST['menuitem'])); 
					}
					else{
						$blacklist =array($_POST['menuitem']); 
					}
					if(in_array($data['parent'],$blacklist))
					{
							header("Location: menu-items.php?menu=".$data['mod_menu_id']."&status=error-parent");
					}
					else
					{
						if($menuitem->Save($_POST['menuitem']))
						{
							header("Location: menu-items.php?menu=".$data['mod_menu_id']."&status=u-success");
						}
						else
						{
							header("Location: menu-items.php?menu=".$data['mod_menu_id']."&status=u-failed");
						}
					}
				  }
				  else
				  {
				  	header("Location: menu-items.php?menu=".$data['mod_menu_id']."&status=invalid-data");
				  }
				  break;
		case 'delete':
					if(intval($_GET['menuitem'])){
						$menuitem = new MenuItem();
						$parent = $menuitem->_getParent($_GET['menuitem']);
						if($parent['child_count']<=0)
						{
							if($menuitem->Delete($_GET['menuitem']))
							{
								header("Location: menu-items.php?menu=".$_GET['menu']."&status=d-success");
							}
							else
							{
								header("Location: menu-items.php?menu=".$_GET['menu']."&status=d-failed");
							}
						}
						else
						{
							header("Location: menu-items.php?menu=".$_GET['menu']."&status=d-failed-u");
						}
					}
					else{
						header("Location: menu-items.php?menu=".$_GET['menu']."&status=invalid-data");
					}
					break;
   }

?>