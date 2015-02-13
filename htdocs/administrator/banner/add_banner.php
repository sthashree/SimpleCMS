
				<div class="blockDistinct" id="data">
                		<h2> <?php echo $t->translate('banner/add-banner');?> </h2>	
				<form action="banner/process_banner.php" method="post" name="banner-form" id="banner-form" enctype="multipart/form-data">
<fieldset>
	<label for="title" class="required"><?php echo $t->translate('banner/banner-title'); ?></label>
		<input type="text" id="title" name="data[banner][title]" tabindex="1" size="50" value="" title="firstname"><br/>
        <label for="meta" class="required"><?php echo $t->translate('event/image'); ?></label>
				<input type="file" id="photo" name="photo" tabindex="9" size="50" value="" title="photo"><br/>
			
			<label for="full_description" class="required"><?php echo $t->translate('label-full-desc'); ?></label>
		<table><tr><td style="padding-left:8px"><textarea name="data[banner][description]" cols="55" id="full_description_<?=$totalLanguage->id;?>" tabindex="8" title="full_description"></textarea>
		</td></tr></table>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('full_description_<?=$totalLanguage->id;?>');
			});
		</script>
        
        <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[event][published]" id="published" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select>
		
</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('banner/add-banner'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
</form>
				</div>
