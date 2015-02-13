<?php 
	require_once('includes/_init.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			ユアーズ
		</title>
        
        <link rel="shortcut icon" href="../images/favicon.ico">
		<?php require_once('includes/_meta.php'); ?>
		<script language="JavaScript" type="text/javascript" src="js/language.helper.js"></script>
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
			<h2> <?php echo $t->translate('language/add-title');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="process_language.php" enctype="multipart/form-data" method="post" name="language-form" id="language-form">
<fieldset>
	<label for="language_name" class="required"><?php echo $t->translate('language/label-name'); ?></label>
		<input type="text" id="language_name" name="data[Language][language]" tabindex="1" size="40" value="" title="language_name"><br>

<label for="abbr" class="required"><?php echo $t->translate('language/label-abbrebiation'); ?></label>
		<input type="text" id="abbr" name="data[Language][abbr]" tabindex="2" size="40" value="" title="abbr"><br/>
<label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Language][published]" id="published" tabindex="3">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select> <br/>
<label for="logo" class="required"><?php echo $t->translate('language/label-logo'); ?></label>
		<input type="file" id="logo" name="logo" tabindex="4" size="40" value="" title="logo">*optional <br/>

</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('language/btn-add'); ?>" id="submit" tabindex="5">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="6">
				</div>
				
				<div class="block">
				<h2>Note:</h2>
				<p>A Language must be defined to enable Multi-Language Content  in the Website</p>
				</div>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>