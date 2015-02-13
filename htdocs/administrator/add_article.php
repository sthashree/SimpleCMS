<?php 
	require_once('includes/_init.php'); 
	include_once('helpers/class.category.php');
	include_once(ADMINPATH.'/helpers/class.language.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			ユアーズ
		</title>
        
        <link rel="shortcut icon" href="../images/favicon.ico">
		<script type="text/javascript" src="js/nicedit.js"></script>
		<?php require_once('includes/_meta.php'); ?>
		<link rel="stylesheet" href="css/modal.css" type="text/css" />
		<script language="JavaScript" type="text/javascript" src="js/article.helper.js"></script>
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
			<h2> <?php echo $t->translate('content/add-title');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="process_article.php" method="post" name="article-form" id="article-form">
<fieldset>
<label for="language" class="required"><?php echo $t->translate('language'); ?></label>
		<select name="data[Article][language_id]" id="language" tabindex="1">
			<?php
				$l = new Language();
				$l->renderLanguageAsOptions();
			?>
		</select><br>
		<label for="category" class="required"><?php echo $t->translate('category/category-label'); ?></label>
		<select name="data[Article][category_id]" id="category" tabindex="1">
			<?php
				$cat_obj = new Category();
				$cat_obj->renderCategoriesAsOptions();
			?>
		</select><br>
	<label for="title" class="required"><?php echo $t->translate('content/label-title'); ?></label>
		<input type="text" id="title" name="data[Article][title]" tabindex="2" size="50" value="" title="title"><br/>
	<label for="keywords" class="required"><?php echo $t->translate('content/label-keyword'); ?></label>
		<input type="text" id="keywords" name="data[Article][keywords]" tabindex="3" size="50" value="" title="keywords"><br/>
			<label for="meta" class="required"><?php echo $t->translate('content/label-meta-desc'); ?></label>
		<input type="text" id="meta" name="data[Article][meta_description]" tabindex="4" size="50" value="" title="meta"><br/>
	
	<label for="short_description" class="required"><?php echo $t->translate('content/label-short-desc'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[Article][short_description]" cols="55" id="short_description" tabindex="5" title="short_description"></textarea>
</td></tr></table>	
			<label for="full_description" class="required"><?php echo $t->translate('content/label-full-desc'); ?></label>
		<table><tr><td style="padding-left:8px"><textarea name="data[Article][full_description]" cols="55" id="full_description" tabindex="6" title="full_description"></textarea>
		</td></tr></table>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('short_description');
			new nicEditor({fullPanel : true}).panelInstance('full_description');
			});
		</script>
			<label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Article][published]" id="published" tabindex="7">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select><br>
		<label for="homepage" class="required"><?php echo $t->translate('label-homepage'); ?></label>
		<select name="data[Article][homepage]" id="homepage" tabindex="8">
			<option value="0" selected="selected">No</option>
			<option value="1">Yes</option>
		</select>
		
</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('content/btn-add'); ?>" id="submit" tabindex="6">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="7">
				</div>
				
				<div class="block">
				<h2>Note:</h2>
				<p>A article may be a page, news or event as per choice. All articles are categorized i.e. An article belongs to a category.</p>
				</div>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>