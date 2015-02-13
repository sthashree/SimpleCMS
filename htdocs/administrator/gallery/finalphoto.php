<?php
	
	$getGallery=$_GET['gallery'];
	$searchString = "gallery_id=$getGallery and final=0";
	$gallery_obj = new Gallery();
	$photos = $gallery_obj->SearchPhoto($searchString);
	 
/*	 
	$uploaddir = './uploads/';
	include_once('helpers/class.imageupload.php');

	foreach($photos as $photo) {
	$ext=explode('.',$photo->photo);
	$ext=$ext[count($ext)-1];
	return $name=time().".".$ext;
	rename($uploaddir.$photo->photo,$uploaddir.$name);
	$name = $photo->photo;
	$imageUpload = new ImageUpload($_FILES['uploadfile'],1,$uploaddir,$name);
	$imageUpload->createthumb();
	}
	$photos = $gallery_obj->SearchPhoto($searchString);
	*/ 
	 

?>
<h2> <?php echo $t->translate('mygallery/configure');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="gallery/process_photo.php" method="post" name="add-photo-form" id="add-photo-form" enctype="multipart/form-data">
<fieldset>
	<?php
		$i=0;
	 foreach($photos as $photo)
{ 
	$i++;
?>
	<div class="photo_image">
	<img src="gallery/photo/thumb/<?=$photo->photo;?>" width="150" /><br/>
    <input type="hidden" name="data[<?=$i;?>][photo]" value="<?=$photo->photo;?>" />
	</div>
    <div class="photo_description">
        <label for="description" class="required"><?php echo $t->translate('desc'); ?></label>	
        <table><tr><td style="padding-left:8px"><textarea name="data[<?=$i;?>][photo_description]" cols="35" id="photo_description" tabindex="7" title="photo_description"><?=$photo->photo_description;?></textarea>
    </td></tr></table>	
            <script type="text/javascript">
                bkLib.onDomLoaded(function() {
                new nicEditor({fullPanel : true}).panelInstance('photo_description');
                });
            </script>
                    
                <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
                <select name="data[<?=$i;?>][published]" id="published" tabindex="10">
                    <option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
                    <option value="0"><?php echo $t->translate("unpublish"); ?></option>
                </select>
                <input type="hidden" name="data[<?=$i;?>][id]" value="<?=$photo->id;?>"/>
   	</div>
    <div style="clear:both;">&nbsp;</div>
            <?php } ?>
</fieldset>
<input type="hidden" name="action" value="finalphoto"/><!-- -->
<input type="submit" value="<?php echo $t->translate('publish'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
				</div>
