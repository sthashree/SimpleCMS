var status = false;
function focusField(v,m,f){
      $("#title").focus();
}
$(function(){
	$("#article-form").submit(function(){
		var error = '';
		var i = 1;
		if($('#title').val()=='')
		{
			error = error + i + '. Title can\'t be null.<br/>';
			++i;
		}

		if($('#keywords').val()=='')
		{
			error = error + i + '. Keywords can\'t be null.<br/>';
			++i;
		}
		if(i>1){
			$.prompt(error,{ callback: focusField });
		}else{
			if(confirm('Are you sure you want to commit action for an Article ?'))
			{
				return true;
			}
		}
		return false;
	});
	
});
