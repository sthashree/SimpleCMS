<?php 
	require_once('includes/_init.php'); 
	require_once("helpers/class.language.php");
	$l = new Language();
	$language = $l->Find(null,$_GET['language']);
	if(!is_object($language))
	{
		header('Location: languages.php?status=invalid');
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
			<h2> <?php echo $t->translate('language/edit-title');?> </h2>	
				<div class="blockDistinct" id="data">
                <form action="process_language.php" enctype="multipart/form-data" method="post" name="language-form" id="language-form">
<fieldset>
	<label for="language_name" class="required"><?php echo $t->translate('language/label-name'); ?></label>
		<input type="text" id="language_name" name="data[Language][language]" tabindex="1" size="40" value="<?php echo $language->language; ?>" title="language_name"><br>

<label for="abbr" class="required"><?php echo $t->translate('language/label-abbrebiation'); ?></label>
		<input type="text" id="abbr" name="data[Language][abbr]" tabindex="2" size="40" value="<?php echo $language->abbr; ?>" title="abbr"><br/>
<label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Language][published]" id="published" tabindex="3">
			<?php if($language->published == 1): ?>
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<?php else: ?>
			<option value="1"><?php echo $t->translate("publish"); ?></option>
			<?php endif; ?>
			<?php if($language->published == 0): ?>
			<option value="0" selected="selected"><?php echo $t->translate("unpublish"); ?></option>
			<?php else: ?>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
			<?php endif; ?>
		</select> <br/>
<label for="logo" class="required"><?php echo $t->translate('language/label-logo'); ?></label>
		<input type="file" id="logo" name="logo" tabindex="4" size="40" value="" title="logo">*optional <br/>

</fieldset>
<input type="hidden" name="action" value="update"/><!-- -->
<input type="hidden" name="language" value="<?php echo $language->id; ?>"/>
<input type="submit" value="<?php echo $t->translate('language/btn-update'); ?>" id="submit" tabindex="5">
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