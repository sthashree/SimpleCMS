var status = false;
function focusField(v,m,f){
      $("#menu_name").focus();
}
$(function(){
	
	$("#menu-form").submit(function(){
		var error = '';
		var i = 1;
		if($('#menu_name').val()=='')
		{
			error = error + i + '. Menu Name can\'t be null.<br/>';
			++i;
		}

		if($('#unique_name').val()=='')
		{
			error = error + i + '. Unique Name can\'t be null.<br/>';
			++i;
		}
		
		if(i>1){
			$.prompt(error,{ callback: focusField });
		}else{
			if(confirm('Are you sure you want to commit action for a Menu Module ?'))
			{
				return true;
			}
		}
		return false;
	});
	
});
