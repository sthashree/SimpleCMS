<script type="text/javascript" language="javascript" src="product/js/script.js"></script>

			<h2> <?php echo $t->translate('myproduct/add-product');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="product/process_product.php" method="post" name="product-form" id="product-form" enctype="multipart/form-data">
<fieldset>
	<?php $categories = $productObj->Find(0); ?>
	<label for="title" class="required"><?php echo $t->translate('myproduct/category'); ?></label>
		<?php echo SelectList("category",$categories,"category_name","","selectSub()"); ?> <br />
    <div id="subcat"></div>    
	
	<label for="title" class="required"><?php echo $t->translate('myproduct/product-title'); ?></label>
		<input type="text" id="product_title" name="data[product][product_title]" tabindex="1" size="50" value="" title="product_title"><br/>
        <label for="title" class="required"><?php echo $t->translate('myproduct/product-price'); ?></label>
		<input type="text" id="firstname" name="data[product][product_price]" tabindex="1" size="50" value="" title="price"><br/>
	<label for="short_description" class="required"><?php echo $t->translate('label-short-desc'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[product][short_description]" cols="55" id="short_description" tabindex="7" title="short_description"></textarea>
</td></tr></table>	
			<label for="full_description" class="required"><?php echo $t->translate('label-full-desc'); ?></label>
		<table><tr><td style="padding-left:8px"><textarea name="data[product][product_description]" cols="55" id="full_description" tabindex="8" title="full_description"></textarea>
		</td></tr></table>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('short_description');
			new nicEditor({fullPanel : true}).panelInstance('full_description');
			});
		</script>
        
			<label for="meta" class="required"><?php echo $t->translate('myproduct/image'); ?></label>
				<input type="file" id="photo" name="photo" tabindex="9" size="50" value="" title="photo"><br/>
			<label for="meta" class="required"><?php echo $t->translate('myproduct/display_ingallery'); ?></label>
				<input type="checkbox" value="1" id="starttime" name="data[product][display_ingallery]" title="display_ingallery"><br />
                
			<label for="meta" class="required"><?php echo $t->translate('myproduct/todaySpecial'); ?></label>
				<input type="checkbox" value="1" id="todaySpecial" name="data[product][todaySpecial]" title="todaySpecial"><br />
                
			<label for="meta" class="required"><?php echo $t->translate('myproduct/is-featured'); ?></label>
				<input type="checkbox" id="isfeatured" name="data[product][isfeatured]" value="1" title="isfeatured"><br />
            <label for="published" class="required"><?php echo $t->translate('order'); ?></label>
                <input type="checkbox" name="data[product][ordering]" /><br />
        <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[product][publish]" id="published" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select>
		
</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('myproduct/btn-add-product'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
</form>
				</div>
