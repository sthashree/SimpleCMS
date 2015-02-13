<h2> <?php echo $t->translate('mygallery/configure');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="gallery/process_gallery.php" method="post" name="add-gallery-form" id="add-gallery-form" enctype="multipart/form-data">
<fieldset>
	<label for="title" class="required"><?php echo $t->translate('mygallery/gallery-title'); ?></label>
		<input type="text" id="title" name="data[Gallery][gallery_name]" tabindex="1" size="50" value="" title="filesize">(default 2MB)<br/>
	<label for="titlealias" class="required"><?php echo $t->translate('mygallery/gallery-title-alias'); ?></label>
		<input type="text" id="galleryname_alias" name="data[Gallery][galleryname_alias]" tabindex="2" size="50" value="" title="galleryname_alias"><br/>
	<label for="description" class="required"><?php echo $t->translate('desc'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[Gallery][gallery_description]" cols="55" id="gallery_description" tabindex="7" title="gallery_description"></textarea>
</td></tr></table>	
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('description');
			});
		</script>
        
			<label for="meta" class="required"><?php echo $t->translate('mygallery/logo-image'); ?></label>
		<input type="file" id="logo" name="logo" tabindex="9" size="50" value="" title="logo"><br/>
			<label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Gallery][published]" id="published" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select>
		
</fieldset>
<input type="hidden" name="action" value="addgallery"/><!-- -->
<input type="submit" value="<?php echo $t->translate('mygallery/btn-add'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
				</div>
