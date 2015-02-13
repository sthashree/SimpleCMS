<?php 
	require_once('includes/_init.php'); 
	include_once(ADMINPATH.'/helpers/class.menuitem.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			ユアーズ
		</title>
        
        <link rel="shortcut icon" href="../images/favicon.ico">
		<?php require_once('includes/_meta.php'); ?>
		<link rel="stylesheet" href="css/facebox.css" type="text/css" />
		<script language="JavaScript" type="text/javascript" src="js/facebox.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/menuitem.helper.js"></script>
		<?php 
		$status = $_GET['status'];
		require_once('includes/_anotification.php'); 
		?>	
	</head>
	<body>
		<div id="topOfPage">
			<a name="topOfPage">&nbsp;</a>
		</div>
		
		<div id="conteiner">
			
			<?php require_once('includes/_header.php'); ?>
			
			<?php require_once('includes/_menu.php'); ?>

			<div id="body">		
			<h2> <?php echo $t->translate('menu-item/add-title');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="process_menuitem.php" method="post" name="menuitem-form" id="menuitem-form">
<fieldset>
	<label for="mod_menu" class="required"><?php echo $t->translate('menu-item/label-module'); ?></label>
		<select name="data[MenuItem][mod_menu_id]" id="mod_menu" tabindex="3">
			<?php
				$m->renderMenuAsOptions($_GET['menu']);
			?>
		</select><br/>

<label for="menuitem_name" class="required"><?php echo $t->translate('menu-item/label-name'); ?></label>
		<input type="text" id="menuitem_name" name="data[MenuItem][menuitem_name]" tabindex="2" size="40" value="" title="menuitem_name"><br>
		
		<label for="menuitem_url" class="required"><?php echo $t->translate('menu-item/label-link'); ?></label>
		<input type="text" id="url" name="data[MenuItem][url]" tabindex="2" size="40" value="" title="article"> (optional)<br>
	<label for="menuitem_article" class="required"><?php echo $t->translate('menu-item/label-article-select'); ?></label>
		<input type="text" id="menuitem_article" tabindex="2" size="40" value="" title="menuitem_article" id="menuitem_article" readonly="readonly">
		<input type="text" id="article" name="data[MenuItem][article]" tabindex="2" size="2" value="" id="article" title="article" readonly="readonly"> 
		<input type="button" id="btnSelect" value="<?php echo $t->translate('btn-select'); ?>"/>
		(optional)<br>
		
	<label for="parent" class="required"><?php echo $t->translate('menu-item/label-parent'); ?></label>
		<select name="data[MenuItem][parent]" style="background-color:#D4DF55" size="8" id="parent" tabindex="3">
			<option value="0" selected="selected">Top</option>
			<?php
				$menuitems = new MenuItem();
				$menuitems->renderMenuItemsAsOptions($_GET['menu'],0,0);
			?>
</select><br>
		
		<label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[MenuItem][published]" id="data[MenuItem][published]" tabindex="4">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select><br>
</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('menu-item/btn-add'); ?>" id="submit" tabindex="5">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="6">
				</div>
				
				<div class="block">
				<h2>Note:</h2>
				<p>A menu item belongs to a menu module. A module may contain many menu items.</p>
				</div>
			
            </div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>