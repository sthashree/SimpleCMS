var status = false;
function focusField(v,m,f){
      $("#firstname").focus();
}
$(function(){
	$("#member-form").submit(function(){
		var error = '';
		var i = 1;
		if($('#firstname').val()=='')
		{
			error = error + i + '. FirstName can\'t be null.<br/>';
			++i;
		}
		
		if($('#email').val()=='')
		{
			error = error + i + '. Email can\'t be null.<br/>';
			++i;
		}
		
		else if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#email').val())) {
			error = error + i + '.Invalid Email Entered.<br />\;
			++i;
			}
		if($('#lastname').val()=='')
		{
			error = error + i + '. LastName can\'t be null.<br/>';
			++i;
		}

		if($('#keywords').val()=='')
		{
			error = error + i + '. Keywords can\'t be null.<br/>';
			++i;
		}
		if($('#fulldescription').val()=='')
		{
			error = error + i + '. Description can\'t be null.<br/>';
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


