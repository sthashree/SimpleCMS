<?php 
	$gallery_obj = new Gallery();
	$configure = $gallery_obj->getConfigure();
		
?>
<h2> <?php echo $t->translate('mygallery/configure');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="gallery/process_photo.php" method="post" name="gallery-configure-form" id="gallery-configure-form" enctype="multipart/form-data">
<fieldset>
	<?php foreach($configure as $conf) { ?>
	<label for="<?=$conf->title;?>" class="required"><?php echo $t->translate('mygallery/file-size'); ?></label>
		<input type="text" id="<?=$conf->title;?>" name="data[][<?=$conf->title;?>]" tabindex="1" size="50" value="<?=$conf->value;?>" title="<?=$conf->title;?>">(default 2MB)<br/>
		<?php } ?>
</fieldset>
<input type="hidden" name="action" value="configure"/><!-- -->
<input type="submit" value="<?php echo $t->translate('save'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
				</div>
