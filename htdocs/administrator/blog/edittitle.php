<script type="text/javascript" language="javascript">
	function updateCategory(item) {
		vals=item.value;
		$("#category").val(vals);
	}
</script>
<?php 

	$objBlog = new Blog();
	$post = $objBlog->FindTitle(0,null,$_GET['blog']);
?>
	<h2> <?php echo $t->translate('myblog/add-title');?> </h2>
    	
				<div class="blockDistinct" id="data">
                
        <div class="leftCategory">
        	<?php
				$objBlog = new Blog();
				$available_blogs = $objBlog->Find();
				//var_dump($available_blogs);
            ?><form name="frmBlogCategory" method="post" action="#" >
            	<ul> <h3>Category Listing</h3>
                <?php foreach($available_blogs as $blog) {  ?>
                	
                	<li><input onclick="updateCategory(this)" type="checkbox" name="category" value="<?=$blog->id;?>" /><?=$blog->category_name;?></li>
             	<?php } ?>    
              	</ul>
                </form>
            </div>	
            <div class="rightCategory">
            <form action="blog/process_title.php" method="post" name="product-form" id="product-form" enctype="multipart/form-data">
<fieldset>
	<input type="hidden" name="category" id="category" value="<?=$post->category_id;?>" />
	
	<label for="title" class="required"><?php echo $t->translate('myblog/blog-title'); ?></label>
		<input type="text" id="product_title" name="data[Blog][title]" tabindex="1" size="40" value="<?=$post->title;?>" title="title"><br/>
	<label for="title" class="required"><?php echo $t->translate('myblog/blog-title-alias'); ?></label>
		<input type="text" id="product_title" name="data[Blog][title_alias]" tabindex="1" size="40" value="<?=$post->title_alias;?>" title="title-alias"><br/>
	<label for="short_description" class="required"><?php echo $t->translate('label-short-desc'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[Blog][short_content]" cols="30" id="short_content" tabindex="" title="short_content"><?=$post->short_content;?></textarea>
</td></tr></table>	
			<label for="full_content" class="required"><?php echo $t->translate('label-full-desc'); ?></label>
		<table><tr><td style="padding-left:8px"><textarea name="data[Blog][content]" cols="30" id="content" tabindex="" title="content"><?=$post->content;?></textarea>
		</td></tr></table>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('short_content');
			new nicEditor({fullPanel : true}).panelInstance('content');
			});
		</script>
        
        <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Blog][published]" id="published" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"  <?php if($post->published==0) { ?> selected="selected" <?php } ?>><?php echo $t->translate("unpublish"); ?></option>
		</select>
		
</fieldset>
<input type="hidden" name="action" value="update"/> 
<input type="hidden" value="<?=$post->id;?>" id="id" name="id" tabindex="11">
<input type="submit" value="<?php echo $t->translate('myblog/btn-edit-topic'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
</form>
			</div>
		</div>
            <div class="clear">&nbsp;</div>
