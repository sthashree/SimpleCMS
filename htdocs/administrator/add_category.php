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
		<script language="JavaScript" type="text/javascript" src="js/category.helper.js"></script>
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
			<h2> <?php echo $t->translate('category/add-title');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="process_category.php" method="post" name="category-form" id="category-form">
<fieldset>
	<label for="category_name" class="required"><?php echo $t->translate('category/category-label'); ?></label>
		<input type="text" id="category_name" name="data[Category][category_name]" tabindex="1" size="40" value="" title="category_name"><br>

<label for="unique_name" class="required"><?php echo $t->translate('label-unique-name'); ?></label>
		<input type="text" id="unique_name" name="data[Category][category_unique_name]" tabindex="2" size="40" value="" title="unique_name"><br>

	<label for="cat_description" class="required"><?php echo $t->translate('label-description'); ?></label>
		<textarea name="data[Category][description]" cols="40" id="cat_description" tabindex="3" title="cat_description"></textarea>
		<br>
</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('category/btn-add'); ?>" id="submit" tabindex="4">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="5">
				</div>
				
				<div class="block">
				<h2>Note:</h2>
				<p>An Article is categorised into categories. An article belongs to a category</p>
				</div>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>