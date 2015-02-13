<?php 
	require_once('includes/_init.php'); 
	include_once(ADMINPATH.'/helpers/class.category.php');
	include_once(ADMINPATH.'/helpers/class.language.php');
	include_once(ADMINPATH.'/helpers/class.article.php');
	$article_obj = new Article();
	$article = $article_obj->Find(0,null,$_GET['article']);
	if(!is_object($article))
	{
		header("Location: contentman.php?status=invalid");
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
		<link rel="stylesheet" href="css/modal.css" type="text/css" />
		<script language="JavaScript" type="text/javascript" src="js/article.helper.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/nicedit.js"></script>
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
				$l->renderLanguageAsOptions($article->language_id);
			?>
		</select><br>
		<label for="category" class="required"><?php echo $t->translate('category/category-label'); ?></label>
		<select name="data[Article][category_id]" id="category" tabindex="1">
			<?php
				$cat_obj = new Category();
				$cat_obj->renderCategoriesAsOptions($article->category_id);
			?>
		</select><br>
	<label for="title" class="required"><?php echo $t->translate('content/label-title'); ?></label>
		<input type="text" id="title" name="data[Article][title]" tabindex="2" size="50" value="<?php echo $article->title; ?>" title="title"><br/>
	<label for="keywords" class="required"><?php echo $t->translate('content/label-keyword'); ?></label>
		<input type="text" id="keywords" name="data[Article][keywords]" tabindex="3" size="50" value="<?php echo $article->keywords; ?>" title="keywords"><br/>
			<label for="meta" class="required"><?php echo $t->translate('content/label-meta-desc'); ?></label>
		<input type="text" id="meta" name="data[Article][meta_description]" tabindex="4" size="50" value="<?php echo $article->meta_description; ?>" title="meta"><br/>
	<label for="short_description" class="required"><?php echo $t->translate('content/label-short-desc'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[Article][short_description]" cols="55" id="short_description" tabindex="5" title="menu_description"><?php echo $article->short_description; ?></textarea>
</td></tr></table>	
			<label for="full_description" class="required"><?php echo $t->translate('content/label-full-desc'); ?></label>
		<table><tr><td style="padding-left:8px"><textarea name="data[Article][full_description]" cols="55" id="full_description" tabindex="6" title="full_description"><?php echo $article->full_description; ?></textarea>
		</td></tr></table>
	<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('short_description');
			new nicEditor({fullPanel : true}).panelInstance('full_description');
			});
	</script>
	<label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Article][published]" id="published" tabindex="7">
			<?php if($article->published == 1): ?>
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<?php else: ?>
			<option value="1"><?php echo $t->translate("publish"); ?></option>
			<?php endif; ?>
			<?php if($article->published == 0): ?>
			<option value="0" selected="selected"><?php echo $t->translate("unpublish"); ?></option>
			<?php else: ?>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
			<?php endif; ?>
		</select><br>
		<label for="homepage" class="required"><?php echo $t->translate('label-homepage'); ?></label>
		<select name="data[Article][homepage]" id="homepage" tabindex="8">
			<?php if($article->homepage == 1): ?>
			<option value="1" selected="selected">Yes</option>
			<?php else: ?>
			<option value="1">Yes</option>
			<?php endif; ?>
			<?php if($article->homepage == 0): ?>
			<option value="0" selected="selected">No</option>
			<?php else: ?>
			<option value="0">No</option>
			<?php endif; ?>
		</select>
</fieldset>
<input type="hidden" name="action" value="update"/><!-- -->
<input type="hidden" name="article" value="<?php echo $article->id; ?>"/>
<input type="submit" value="<?php echo $t->translate('content/btn-update'); ?>" id="submit" tabindex="6">
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