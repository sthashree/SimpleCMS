var status = false;
function focusField(v,m,f){
      $("#language_name").focus();
}
$(function(){
	
	$("#language-form").submit(function(){
		var error = '';
		var i = 1;
		if($('#language_name').val()=='')
		{
			error = error + i + '. Language Name can\'t be null.<br/>';
			++i;
		}

		if($('#abbr').val()=='')
		{
			error = error + i + '. Abbrebiation can\'t be null.<br/>';
			++i;
		}
		
		if(i>1){
			$.prompt(error,{ callback: focusField });
		}else{
			if(confirm('Are you sure you want to commit action for the language ?'))
			{
				return true;
			}
		}
		return false;
	});
	
});
