<?php 
	require_once('includes/_init.php'); 
	include_once(ADMINPATH.'/helpers/class.positionhelper.php');
	include_once(ADMINPATH.'/helpers/class.language.php');
	$p = new PositionHelper('../layout.xml');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			ユアーズ
		</title>
        
        <link rel="shortcut icon" href="../images/favicon.ico">
		<?php require_once('includes/_meta.php'); ?>
		<script language="JavaScript" type="text/javascript" src="js/menu.helper.js"></script>
		<?php require_once('includes/_anotification.php'); ?>	
	</head>
	<body>
		<div id="topOfPage">
			<a name="topOfPage">&nbsp;</a>
		</div>
		
		<div id="conteiner">
			
			<?php require_once('includes/_header.php'); ?>
			
			<?php require_once('includes/_menu.php'); ?>

			<div id="body">		
			<h2> <?php echo $t->translate('menu/add-title');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="process_menu.php" method="post" name="menu-form" id="menu-form">
<fieldset>
<label for="language" class="required"><?php echo $t->translate('language'); ?></label>
		<select name="data[Menu][language_id]" id="language" tabindex="1">
			<?php
				$l = new Language();
				$l->renderLanguageAsOptions();
			?>
		</select><br>
	<label for="menu_name" class="required"><?php echo $t->translate('menu/label-mod-name'); ?></label>
		<input type="text" id="menu_name" name="data[Menu][menu_name]" tabindex="1" size="40" value="" title="event_name"><br>

<label for="unique_name" class="required"><?php echo $t->translate('label-unique-name'); ?></label>
		<input type="text" id="unique_name" name="data[Menu][menu_unique_name]" tabindex="2" size="40" value="" title="unique_name"><br>
	<label for="position" class="required"><?php echo $t->translate('menu/label-position'); ?></label>
		<select name="data[Menu][position]" id="position" tabindex="3">
			<?php
				$p->renderPositionOptions();
			?>
		</select><br>
	<label for="menu_description" class="required"><?php echo $t->translate('label-description'); ?></label>
		<textarea name="data[Menu][description]" cols="40" id="menu_description" tabindex="4" title="menu_description"></textarea><br>
		<br>	<label for="position" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Menu][published]" id="published" tabindex="5">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select><br>
</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('menu/btn-add'); ?>" id="submit" tabindex="6">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="7">
				</div>
				
				<div class="block">
				<h2>Note:</h2>
				<p>A menu module consists of many menu items. These menu are loaded on the basis of position at Front End.</p>
				</div>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>