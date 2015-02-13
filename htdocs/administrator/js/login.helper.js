/**
 * @author Sujan
 */
$(function(){
	$("#UserUsername").focus();
	$("#UserLoginForm").submit(function(){
		if($("#UserUsername").val()=='')
		{
			alert('Please provide Username !');
			$("#UserUsername").focus();
			return false;
		}
		if($("#password").val()=='')
		{
			alert('Please provide Password !');
			$("#password").focus();
			return false;
		}
		return true;
	});
});