<?php 
	require_once('includes/_init.php'); 
	include_once(ADMINPATH.'/helpers/class.category.php');
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
		<script language="JavaScript" type="text/javascript" src="js/member.helper.js"></script>
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
			<h2> <?php echo $t->translate('member/add-title');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="process_member.php" method="post" name="member-form" id="member-form" enctype="multipart/form-data">
<fieldset>
	<label for="title" class="required"><?php echo $t->translate('member/first-name'); ?></label>
		<input type="text" id="firstname" name="data[Member][firstname]" tabindex="1" size="50" value="" title="firstname"><br/>
	<label for="title" class="required"><?php echo $t->translate('member/middle-name'); ?></label>
		<input type="text" id="middlename" name="data[Member][middlename]" tabindex="2" size="50" value="" title="middlename"><br/>
	<label for="title" class="required"><?php echo $t->translate('member/last-name'); ?></label>
		<input type="text" id="lastname" name="data[Member][lastname]" tabindex="2" size="50" value="" title="lastname"><br/>
	<label for="title" class="required"><?php echo $t->translate('member/member-email'); ?></label>
		<input type="text" id="email" name="data[Member][email]" tabindex="4" size="50" value="" title="email"><br/>
	<label for="keywords" class="required"><?php echo $t->translate('member/label-keyword'); ?></label>
		<input type="text" id="keywords" name="data[Member][keywords]" tabindex="5" size="50" value="" title="keywords"><br/>
			<label for="meta" class="required"><?php echo $t->translate('member/label-meta-desc'); ?></label>
		<input type="text" id="meta" name="data[Member][meta_description]" tabindex="6" size="50" value="" title="meta"><br/>
	
	<label for="short_description" class="required"><?php echo $t->translate('member/label-short-desc'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[Member][short_description]" cols="55" id="short_description" tabindex="7" title="short_description"></textarea>
</td></tr></table>	
			<label for="full_description" class="required"><?php echo $t->translate('member/label-full-desc'); ?></label>
		<table><tr><td style="padding-left:8px"><textarea name="data[Member][full_description]" cols="55" id="full_description" tabindex="8" title="full_description"></textarea>
		</td></tr></table>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('short_description');
			new nicEditor({fullPanel : true}).panelInstance('full_description');
			});
		</script>
        
			<label for="meta" class="required"><?php echo $t->translate('member/member-photo'); ?></label>
		<input type="file" id="photo" name="photo" tabindex="9" size="50" value="" title="photo"><br/>
			<label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Member][published]" id="published" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select>
		
</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('member/btn-add'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
</form>
				</div>
				<!--
				<div class="block">
				<h2>Note:</h2>
				<p>A article may be a page, news or event as per choice. All articles are categorized i.e. An article belongs to a category.</p>
				</div>-->
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>