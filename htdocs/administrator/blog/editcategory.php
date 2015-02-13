<?php 

	$objBlog = new Blog();
	$blog = $objBlog->Find(0,null,$_GET['blog']);
?>
			<h2> <?php echo $t->translate('myblog');?> </h2>	

<div class="blockDistinct" id="data">
	<form action="blog/process_blog.php" method="post" name="add-blogCategory-form" id="add-blogCategory-form" enctype="multipart/form-data">
	<fieldset>
	<label for="title" class="required"><?php echo $t->translate('myblog/category-title'); ?></label>
		<input type="text" id="title" name="data[Blog][category_name]" tabindex="1" size="50" value="<?=$blog->category_name;?>" title="filesize"><br/>
	<label for="titlealias" class="required"><?php echo $t->translate('myblog/category-title-alias'); ?></label>
		<input type="text" id="blogname_alias" name="data[Blog][category_name_alias]" tabindex="2" size="50" value="<?=$blog->category_name_alias;?>" title="blogname_alias"><br/>
	<label for="description" class="required"><?php echo $t->translate('desc'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[Blog][category_description]" cols="55" id="category_description" tabindex="7" title="category_description"><?=$blog->category_description; ?></textarea>
</td></tr></table>	
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('category_description');
			});
		</script>
        <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Blog][published]" id="publish" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select>
        <br />
		
    <input type="hidden" name="id" value="<?=$blog->id;?>" />    
	<input type="hidden" name="action" value="editcategory"/><!-- -->
	<input type="submit" value="<?php echo $t->translate('myblog/btn-add'); ?>" id="submit" tabindex="11">
	<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
	</fieldset>
</form>
</div>
