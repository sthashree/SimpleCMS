 <script type="text/javascript" src="<?=ADMINURL;?>/japanese_calendar/jkl-opacity.js" charset="Shift_JIS"></script>
      <script type="text/javascript" src="<?=ADMINURL;?>/japanese_calendar/jkl-calendar.js" charset="Shift_JIS"></script>
      <script>
	        var cal2 = new JKL.Calendar("caldiv2","member-form","data[start_date][day]");
			cal2.setStyle( "frame_color", "#3333CC" );
			var cal3 = new JKL.Calendar("caldiv3","member-form","data[end_date][day]");
			cal3.setStyle( "frame_color", "#CC3333" );
      </script>
<?php 
	$event = $objEvent->Find(0,null,$_GET['event']);
	$start_time = getTime($event->start_time);
	$end_time = getTime($event->end_time);
	if($event->ispublic==1) { $public ="checked='checked'"; }
?>

			<h2> <?php echo $t->translate('event/edit-event');?> </h2>	
	<div class="blockDistinct" id="data">
				<form action="events/process_event.php" method="post" name="member-form" id="member-form" enctype="multipart/form-data">
<fieldset>
	<?php foreach($totalLanguages as $totalLanguage) { ?>
	<label for="title" class="required"><?php echo $t->translate('event/event-title'); ?>[<?=$totalLanguage->abbr;?>]</label>
		<input type="text" id="firstname" name="data[event][title][<?=$totalLanguage->abbr;?>]" tabindex="1" size="50" title="title" value="<?=getLanguageSpecific($event->title,$totalLanguage->abbr);?>"><br/>
	<label for="short_description" class="required"><?php echo $t->translate('label-short-desc'); ?>[<?=$totalLanguage->abbr;?>]</label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[event][short_description][<?=$totalLanguage->abbr;?>]" cols="55" id="short_description_<?=$totalLanguage->id;?>" tabindex="7" title="short_description"><?=getLanguageSpecific($event->short_description,$totalLanguage->abbr);?></textarea>
</td></tr></table>	
			<label for="full_description" class="required"><?php echo $t->translate('label-full-desc'); ?>[<?=$totalLanguage->abbr;?>]</label>
		<table><tr><td style="padding-left:8px"><textarea name="data[event][description][<?=$totalLanguage->abbr;?>]" cols="55" id="full_description_<?=$totalLanguage->id;?>" tabindex="8" title="full_description"><?=getLanguageSpecific($event->description,$totalLanguage->abbr);?></textarea>
		</td></tr></table>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('short_description_<?=$totalLanguage->id;?>');
			new nicEditor({fullPanel : true}).panelInstance('full_description_<?=$totalLanguage->id;?>');
			});
		</script>
        
		<?php } ?>
			<label for="meta" class="required"><?php echo $t->translate('event/image'); ?></label>
				<img src="events/photo/<?=$event->image;?>" width="120" style="padding:2px; border:1px solid #666666; margin-left:10px" /><input type="file" id="photo" name="photo" tabindex="9" size="25" value="" title="photo"><br/>
			<label for="meta" class="required"><?php echo $t->translate('event/start-date'); ?></label>
				<input type="text" id="starttime" name="data[start_date][day]" tabindex="1" size="9" value="<?=$start_time['day'];?>" title="start-time" onClick="cal3.hide(); cal2.write();" onChange="cal2.getFormValue(); cal2.hide();">
                <?=$objEvent->getHours('start_date',$start_time['hour']);?>&nbsp;<?php echo $t->translate('event/h'); ?>&nbsp;&nbsp;<?=$objEvent->getMinutes('start_date',$start_time['minute']).$t->translate('event/m'); ?><br/><div id="caldiv2"></div>
			<label for="meta" class="required"><?php echo $t->translate('event/end-date'); ?></label>
				<input type="text" id="endtime" name="data[end_date][day]" tabindex="1" size="9" value="<?=$end_time['day'];?>" title="end-time" onClick="cal2.hide(); cal3.write();" 
        onChange="cal3.getFormValue(); cal3.hide();">
                <?=$objEvent->getHours('end_date',$end_time['hour']);?>&nbsp;<?php echo $t->translate('event/h'); ?>&nbsp;&nbsp;<?=$objEvent->getMinutes('end_date',$end_time['minute']).$t->translate('event/m'); ?><br/><div id="caldiv3"></div>
            <label for="published" class="required"><?php echo $t->translate('event/public'); ?></label>
                <input type="checkbox" name="data[event][ispublic]" <?=$public;?> value="1"/><br />
        <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[event][published]" id="published" tabindex="10">
			<option value="1" selected="selected" ><?php echo $t->translate("publish"); ?></option>
			<option value="0"  <?php if($event->published==0) { ?> selected="selected" <?php } ?>><?php echo $t->translate("unpublish"); ?></option>
		</select>
</fieldset>
<input type="hidden" name="action" value="update"/><!-- -->
<input type="hidden" name="event" value="<?php echo $event->id; ?>"/>
<input type="submit" value="<?php echo $t->translate('event/btn-update'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
</form>
				</div>
