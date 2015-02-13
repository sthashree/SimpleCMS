var status = false;
function focusField(v,m,f){
      $("#category_name").focus();
}
$(function(){
	
	$("#category-form").submit(function(){
		var error = '';
		var i = 1;
		if($('#category_name').val()=='')
		{
			error = error + i + '. Category Name can\'t be null.<br/>';
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
			if(confirm('Are you sure you want to commit action for the Category ?'))
			{
				return true;
			}
		}
		return false;
	});
	
});
