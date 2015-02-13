 <script type="text/javascript" src="<?=ADMINURL;?>/japanese_calendar/jkl-opacity.js" charset="Shift_JIS"></script>
      <script type="text/javascript" src="<?=ADMINURL;?>/japanese_calendar/jkl-calendar.js" charset="Shift_JIS"></script>
      
<?php
	$chirasidate = ($_GET['chirasidate']);
	$searchString = " chirasidate='$chirasidate'";
	$gallery_obj = new Chirasi();
	$photos = $gallery_obj->Search($searchString);
	 
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
<h2> <?php echo $t->translate('chirasi/configure');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="chirasi/process_chirasi.php" method="post" name="add-photo-form" id="add-photo-form" enctype="multipart/form-data">
<fieldset>
	<?php
		$i=0;
	 foreach($photos as $photo)
{ 
	$i++;
?>
	<div class="photo_image">
	<img src="chirasi/uploads/<?=$photo->photo;?>" width="150" /><br/>
    <input type="file" name="data[<?=$i;?>][photo]" size="15" />
	</div>
    <div class="photo_description">
    <div>
    <label for="Date" class="required"><?php echo $t->translate('date'); ?></label>
               <input type="text" value="<?=$photo->chirasidate;?>" name="data[<?=$i;?>][chirasidate]" onClick="cal_<?=$i;?>.write();" onChange="cal_<?=$i;?>.getFormValue(); cal_<?=$i;?>.hide();">
               <div id="calid_<?=$i;?>"></div>
        </div>
        <div>
        <label for="published" class="required"><?php echo $t->translate('front'); ?></label>
                <select name="data[<?=$i;?>][front]" id="published" tabindex="10">
                    <option value="1" <?php if($photo->front==1) { ?> selected="selected" <?php } ?>><?php echo $t->translate("front"); ?></option>
                    <option value="0" <?php if($photo->front==0) { ?> selected="selected" <?php } ?>><?php echo $t->translate("back"); ?></option>
                </select>
             </div>
             <div>   
        <label for="description" class="required"><?php echo $t->translate('desc'); ?></label>	
        <table><tr><td style="padding-left:8px"><textarea name="data[<?=$i;?>][photo_description]" cols="35" id="photo_description" tabindex="7" title="photo_description"><?=$photo->photo_description;?></textarea>
    </td></tr></table>	
    </div>
            <script type="text/javascript">
                bkLib.onDomLoaded(function() {
                new nicEditor({fullPanel : true}).panelInstance('photo_description');
                });
            </script>
            <script>
        var cal_<?=$i;?> = new JKL.Calendar("calid_<?=$i;?>","add-photo-form","data[<?=$i;?>][chirasidate]");
      </script>
          <div>          
                <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
                <select name="data[<?=$i;?>][published]" id="published" tabindex="10">
                    <option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
                    <option value="0"><?php echo $t->translate("unpublish"); ?></option>
                </select>
                <input type="hidden" name="data[<?=$i;?>][id]" value="<?=$photo->id;?>"/>
   	</div>
    </div>
    <div style="clear:both;">&nbsp;</div>
            <?php } ?>
</fieldset>

<input type="hidden" name="action" value="editchirasi"/><!-- -->
<input type="submit" value="<?php echo $t->translate('publish'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
				</div>
