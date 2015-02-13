<?php 
	$product = $productObj->FindProduct(0,null,$_GET['event']);
	//$start_time = getTime($event->start_time);
	//$end_time = getTime($event->end_time);
	//if($event->ispublic==1) { $public ="checked='checked'"; }
?>

			<h2> <?php echo $t->translate('myproduct/add-product');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="product/process_product.php" method="post" name="product-form" id="product-form" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?=$product->id;?>">
<fieldset>
	<label for="title" class="required"><?php echo $t->translate('product/product-title'); ?></label>
		<input type="text" id="firstname" name="data[product][product_title]" tabindex="1" size="50" value="<?=$product->product_title;?>" title="firstname"><br/>
        <label for="title" class="required"><?php echo $t->translate('product/product-price'); ?></label>
		<input type="text" id="firstname" name="data[product][product_price]" tabindex="1" size="50" value="<?=$product->product_price;?>" title="price"><br/>
	<label for="short_description" class="required"><?php echo $t->translate('label-short-desc'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[product][short_description]" cols="55" id="short_description" tabindex="7" title="short_description"><?=$product->short_description;?></textarea>
</td></tr></table>	
			<label for="full_description" class="required"><?php echo $t->translate('label-full-desc'); ?></label>
		<table><tr><td style="padding-left:8px"><textarea name="data[product][product_description]" cols="55" id="full_description" tabindex="8" title="full_description"><?=$product->product_description;?></textarea>
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
				<input type="checkbox" <?php if($product->display_ingallery==1) { ?> checked="checked" <?php } ?> id="starttime" name="data[product][display_ingallery]" title="display_ingallery">
			<label for="meta" class="required"><?php echo $t->translate('myproduct/is-featured'); ?></label>
				<input type="checkbox" id="isfeatured" name="data[myproduct][isfeatured]" <?php if($product->isfeatured==1) { ?> checked="checked" <?php } ?> title="isfeatured">
            <label for="published" class="required"><?php echo $t->translate('order'); ?></label>
                <input type="text" value="<?=$product->ordering;?>" name="data[myproduct][ordering]" /><br />
        <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[event][publish]" id="published" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0" <?php if($product->publish==0) { ?> selected="selected" <?php } ?>><?php echo $t->translate("unpublish"); ?></option>
		</select>
</fieldset>
<input type="hidden" name="action" value="update"/><!-- -->
<input type="hidden" name="event" value="<?php echo $event->id; ?>"/>
<input type="submit" value="<?php echo $t->translate('myproduct/btn-update-product'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
</form>
				</div>
