<?php 

	$productObj = new Product();
	$category = $productObj->Find(0,null,$_GET['product']);
?>

<h2> <?php echo $t->translate('product/add-product');?> </h2>	
			<div class="blockDistinct" id="data">
                <?php $category_full = $productObj->Find(); 
				//var_dump($category_full);?>
				<form action="product/process_category.php" method="post" name="add-product-form" id="add-gallery-form" enctype="multipart/form-data">
<fieldset>
	<label for="title" class="required"><?php echo $t->translate('myproduct/category-parent'); ?></label>
	<?php echo SelectList("data[Category][parent_id]",$category_full,"category_name"); ?><br />
	<label for="title" class="required"><?php echo $t->translate('myproduct/category-title'); ?></label>
		<input type="text" id="title" name="data[Product][product_name]" tabindex="1" size="50" value="<?=$category->category-title;?>" title="filesize"><br/>

	<label for="description" class="required"><?php echo $t->translate('desc'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[Category][category_description]" cols="55" id="category_description" tabindex="7" title="gallery_description"><?=$category->category_description;?></textarea>
</td></tr></table>	
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('category_description');
			});
		</script>
         <label for="order" class="required"><?php echo $t->translate('order'); ?></label>	
        <input type="text" id="title" name="data[Category][ordering]" tabindex="4" size="50" value="<?=$category->ordering;?>" title="filesize"><br/>
        
			<label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Category][publish]" id="published" tabindex="10">
			<option value="1" <?php if($category->publish==1) { ?> selected="selected" <?php } ?>><?php echo $t->translate("publish"); ?></option>
			<option value="0" <?php if($category->publish==0) { ?> selected="selected" <?php } ?>><?php echo $t->translate("unpublish"); ?></option>
		</select>
		
</fieldset>
<input type="hidden" name="action" value="addcategory"/><!-- -->
<input type="submit" value="<?php echo $t->translate('myproduct/btn-add'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
				</div>
