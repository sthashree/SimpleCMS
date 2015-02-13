 <script type="text/javascript" src="<?=ADMINURL;?>/japanese_calendar/jkl-opacity.js" charset="Shift_JIS"></script>
      <script type="text/javascript" src="<?=ADMINURL;?>/japanese_calendar/jkl-calendar.js" charset="Shift_JIS"></script>
      <script>
	        var cal2 = new JKL.Calendar("caldiv2","event-form","data[start_date][day]");
			cal2.setStyle( "frame_color", "#3333CC" );
			var cal3 = new JKL.Calendar("caldiv3","event-form","data[end_date][day]");
			cal3.setStyle( "frame_color", "#CC3333" );
      </script>
<?php //var_dump($totalLanguages); ?>		<h2> <?php echo $t->translate('event/add-event');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="events/process_event.php" method="post" name="event-form" id="event-form" enctype="multipart/form-data">
<fieldset>
	<?php foreach($totalLanguages as $totalLanguage) { ?>
	<label for="title" class="required"><?php echo $t->translate('event/event-title'); ?>[<?=$totalLanguage->abbr;?>]</label>
		<input type="text" id="firstname" name="data[event][title][<?=$totalLanguage->abbr;?>]" tabindex="1" size="50" value="" title="firstname"><br/>
        
	<label for="short_description" class="required"><?php echo $t->translate('label-short-desc'); ?>[<?=$totalLanguage->abbr;?>]</label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[event][short_description][<?=$totalLanguage->abbr;?>]" cols="55" id="short_description_<?=$totalLanguage->id;?>" tabindex="7" title="short_description"></textarea>
</td></tr></table>	
			<label for="full_description" class="required"><?php echo $t->translate('label-full-desc'); ?>[<?=$totalLanguage->abbr;?>]</label>
		<table><tr><td style="padding-left:8px"><textarea name="data[event][description][<?=$totalLanguage->abbr;?>]" cols="55" id="full_description_<?=$totalLanguage->id;?>" tabindex="8" title="full_description"></textarea>
		</td></tr></table>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('short_description_<?=$totalLanguage->id;?>');
			new nicEditor({fullPanel : true}).panelInstance('full_description_<?=$totalLanguage->id;?>');
			});
		</script>
        
		<?php } ?>
        	<label for="meta" class="required"><?php echo $t->translate('event/image'); ?></label>
				<input type="file" id="photo" name="photo" tabindex="9" size="50" value="" title="photo"><br/>
			<label for="meta" class="required"><?php echo $t->translate('event/start-date'); ?></label>
				<input type="text" id="starttime" name="data[start_date][day]" tabindex="1" size="12"  title="start-time" onClick="cal3.hide(); cal2.write();" onChange="cal2.getFormValue(); cal2.hide();">
                <?=$objEvent->getHours('start_date');?>&nbsp;<?php echo $t->translate('event/h'); ?>&nbsp;&nbsp;<?=$objEvent->getMinutes('start_date').$t->translate('event/m'); ?> <br/><div id="caldiv2"></div>
			<label for="meta" class="required"><?php echo $t->translate('event/end-date'); ?></label>
				<input type="text" id="endtime" name="data[end_date][day]" tabindex="1" size="12"  title="end-time" onClick="cal2.hide(); cal3.write();" 
        onChange="cal3.getFormValue(); cal3.hide();">
                <?=$objEvent->getHours('end_date');?>&nbsp;<?php echo $t->translate('event/h'); ?>&nbsp;&nbsp;<?=$objEvent->getMinutes('end_date').$t->translate('event/m'); ?><br/><div id="caldiv3"></div>
            <label for="published" class="required"><?php echo $t->translate('event/public'); ?></label>
                <input type="checkbox" name="data[ispublic]" /><br />
        <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[event][published]" id="published" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select>
		
</fieldset>
<input type="hidden" name="action" value="add"/><!-- -->
<input type="submit" value="<?php echo $t->translate('event/btn-add'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
</form>
				</div>
