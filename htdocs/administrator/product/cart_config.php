<script type="text/javascript" language="javascript" src="product/js/script.js"></script>

			<h2> <?php echo $t->translate('myproduct/config');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="product/process_config.php" method="post" name="product-form" id="product-form" enctype="multipart/form-data">
<fieldset>
	<label for="title" class="required"><?php echo $t->translate('myproduct/tax-percentage'); ?></label>
		<input type="text" id="tax" name="data[product][tax]" tabindex="1" size="50" value="" title="tax"><br/>
        <label for="title" class="required"><?php echo $t->translate('myproduct/delivery-cahrge'); ?></label>
		<input type="text" id="delivery-charge" name="data[product][deliver_charge]" tabindex="1" size="50" value="" title="delivery_charge"><br/>
</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('myproduct/save-config'); ?>" id="submit" tabindex="11">
</form>
				</div>
