<h2> <?php echo $t->translate('user/usergroup-new');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="user/process_userrole.php" method="post" name="add-gallery-form" id="add-gallery-form" enctype="multipart/form-data">
<fieldset>
	<label for="title" class="required"><?php echo $t->translate('user/type-title'); ?></label>
		<input type="text" id="type" name="data[User][type]" tabindex="1" size="50" value="" title="filesize"><br/>
	<label for="titlealias" class="required"><?php echo $t->translate('user/type-title-alias'); ?></label>
		<input type="text" id="galleryname_alias" name="data[User][type_alias]" tabindex="2" size="50" value="" title="galleryname_alias"><br/>
	<label for="description" class="required"><?php echo $t->translate('label-description'); ?></label>	
	<table><tr><td style="padding-left:8px"><textarea name="data[User][description]" cols="55" id="description" tabindex="7" title="description"></textarea>
</td></tr></table>	
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('description');
			});
		</script>
        
	<label for="description" class="required"><?php echo $t->translate('user/role'); ?></label>	
        <?php 
				$userrole = new Usertype();
				$available_userrole = $userrole->FindRole();
				//var_dump($available_userrole);
				
		?>
        <select name="data[Role][]" id="roles" tabindex="10" multiple="multiple">
        <option>Select One </option>
        
        <?php foreach($available_userrole as $role) { ?>
			<option value="<?php echo $role->id;?>" selected="selected"><?php  echo $role->role; ?></option>
			<?php } ?></select>

        <br />
	<label for="description" class="required"><?php echo $t->translate('label-status'); ?></label>	
		<select name="data[User][published]" id="published" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select>
		
</fieldset>
<input type="hidden" name="action" value="addusertype"/><!-- -->
<input type="submit" value="<?php echo $t->translate('user/btn-add'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
				</form>
                </div>
