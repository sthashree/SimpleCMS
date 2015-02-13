<?php 

$users = new Users();
$data = $users->Find($_GET['id']);
?> 
<h2> <?php echo $t->translate('user/user-new');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="user/process_user.php" method="post" name="member-form" id="member-form" enctype="multipart/form-data">
<fieldset>
	<div>
			<label for="title" class="required"><?php echo $t->translate('member/first-name'); ?></label>
			<input type="text" id="firstname" name="data[Member][firstname]" tabindex="1" size="50" value="<?php echo $data->firstname; ?>" title="firstname" class="required" >
    </div>
    <div>    
        <label for="title" class="required"><?php echo $t->translate('member/middle-name'); ?></label>
            <input type="text" id="middlename" name="data[Member][middlename]" tabindex="2" size="50" value="<?php echo $data->middlename; ?>" title="middlename">
  	</div>
    <div>
		<label for="title" class="required"><?php echo $t->translate('member/last-name'); ?></label>
		<input type="text" id="lastname" name="data[Member][lastname]" tabindex="2" size="50" value="<?php echo $data->lastname; ?>" title="lastname"  class="required" >
	</div>
    <div>
    	<label for="title" class="required"><?php echo $t->translate('member/member-email'); ?></label>
		<input type="text" id="email" name="data[Member][email]" tabindex="4" size="50" value="<?php echo $data->email; ?>" title="email" class="validate">
 	</div>
    <div>
		<label for="keywords" class="required"><?php echo $t->translate('label-mobile'); ?></label>
            <input type="text" id="mobile" name="data[Member][mobile]" tabindex="5" size="50" value="<?php echo $data->mobile; ?>" title="keywords">
 	</div>
    <div>           
		<label for="meta" class="required"><?php echo $t->translate('label-phone'); ?></label>
		<input type="text" id="phone" name="data[Member][phone]" tabindex="6" size="50" value="<?php echo $data->phone; ?>" title="meta">
	</div>
    <div>
        <label for="short_description" class="required"><?php echo $t->translate('label-address'); ?></label>	
        <table><tr><td style="padding-left:8px">
        	<textarea name="data[Member][address]" cols="55" id="address" tabindex="7" title="address"><?php echo $data->address; ?></textarea>
    	</td></tr></table>	
            <script type="text/javascript">
			bkLib.onDomLoaded(function() {
			new nicEditor({fullPanel : true}).panelInstance('address');
			});
		</script>
    </div>    
	<div>
    	<label for="meta" class="required"><?php echo $t->translate('member/member-photo'); ?></label>
        <img src="user/photo/thumb/<?=$data->photo;?>" width="120"  /><input type="file" id="photo" name="photo" tabindex="" size="35" title="photo">
	</div>		    
    <div>        
		<label for="keywords" class="required"><?php echo $t->translate('user/label-username'); ?></label>
		<input type="text" id="username" name="data[Member][username]" tabindex="" size="50" value="<?=$data->username;?>" title="username"  class="required" >
 	</div>
    <div>
    	<label for="meta" class="required"><?php echo $t->translate('user/label-password'); ?></label>
		<input type="password" name="data[Member][password]" tabindex="" id="password" size="50" value="" title="meta" onblur="addConfirm();">
    </div>
    <div>
		<label for="meta" class="required"><?php echo $t->translate('user/label-repassword'); ?></label>
		<input type="password" name="repassword" id="repassword" tabindex="" size="50" value="" title="meta" >
	</div>
    <div>
    	<label for="meta" class="required"><?php echo $t->translate('user/usertype'); ?></label>
        
        <?php 
				$usertype = new Usertype();
				$available_usertype = $usertype->Find();
			echo SelectList('data[Member][user_type]',$available_usertype,'type',$data->user_type);
			?>
	</div>
    <div>
		<label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
		<select name="data[Member][published]" id="published" tabindex="10">
			<option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
			<option value="0"><?php echo $t->translate("unpublish"); ?></option>
		</select>
	</div>	
</fieldset>
<input type="hidden" name="data[Member][active]" value="1"/>
<input type="hidden" name="data[Member][date_joined]" value="<?=date("Y-m-d");?>"/>
<input type="hidden" name="action" value="update"/>
<input type="hidden" name="id" value="<?=$data->id;?>"/><!-- -->
<input type="submit" value="<?php echo $t->translate('user/btn-edit'); ?>" id="submit" tabindex="11"  onclick="return buttonClick(this);">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
</form>
				</div>
                
<script type="text/javascript" language="javascript">

</script>
