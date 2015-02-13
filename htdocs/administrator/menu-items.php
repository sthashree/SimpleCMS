<?php 
require_once('includes/_init.php'); 
include_once(ADMINPATH.'/helpers/class.menuitem.php');
$menu_module = $m->Find(null,$_GET['menu']);
if(!is_object($menu_module))
{
	print "<h5>Invalid Operation. Menu Module Doesnot Exists</h5>";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			ユアーズ
		</title>
        
        <link rel="shortcut icon" href="../images/favicon.ico">
		<?php require_once('includes/_meta.php'); ?>
		<link rel="stylesheet" href="css/treeview.css" />
		<script src="js/treeview.min.js" type="text/javascript"></script>
		<?php require_once('includes/_unotification.php'); ?>	
		<script type="text/javascript">
			$(function(){
				$("#menuitem").treeview();
			});
			
		</script>
	</head>
	<body>
		<div id="topOfPage">
			<a name="topOfPage">&nbsp;</a>
		</div>
		
		<div id="conteiner">
			
			<?php require_once('includes/_header.php'); ?>
			
			<?php require_once('includes/_menu.php'); ?>

			<div id="body">		
			<h2> <?php echo $t->translate('menu-item/view-title');?> <?php echo $menu_module->menu_name; ?> </h2>	
				<div class="blockDistinct">
				<a href="add_menuitem.php?menu=<?php echo $menu_module->id; ?>"><img src="images/new.png" alt="<?php echo $t->translate('menu-item/menuitem-new-name');?>" title="<?php echo $t->translate('menu-item/menuitem-new-name');?>"></a>
				</div>
				<div class="block">
					
					
					<ul id="menuitem" class="filetree">
						<?php
						$menuitems = new MenuItem();
						$menuitems->renderMenuItemsAsList($_GET['menu'],$t,0,0);
						?>
					</ul>
				<?php 
				?>
				</div>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>