var status = false;
function focusField(v,m,f){
      $("#menuitem_name").focus();
}
function selectArticle(t,v)
{
	document.getElementById("article").value = v;
	document.getElementById("menuitem_article").value = t;
	jQuery.facebox.close();
	return false;
}
function loadURL(v)
{
	$("#article-container").html("<img src=\"images/loading.gif\" />");
	$.get(v,null,function(data){
				$("#article-container").html(data);
			});
}
function loadArticles(v)
{
	$("#article-container").html("<img src=\"images/loading.gif\" />");
	$.get('view_articles.php',v,function(data){
				$("#article-container").html(data);
			});
}
$(function(){
	
	$("#btnSelect").click(function(){
		$.get('view_articles.php',{m:$("#mod_menu").val()},function(data) {
    		jQuery.facebox("<div id=\"article-container\">" + data + "</div>" )
		return false;
  		});
	});
	
	$("#menuitem-form").submit(function(){
		var error = '';
		var i = 1;
		if($('#mod_menu').val()<=0)
		{
			error = error + i + '. Menu Module can\'t be null.<br/>';
			++i;
		}

		if($('#menuitem_name').val()=='')
		{
			error = error + i + '. Display Name can\'t be null.<br/>';
			++i;
		}
		
		if(i>1){
			$.prompt(error,{ callback: focusField });
		}else{
			if(confirm('Are you sure you want to commit action for a Menu Item ?'))
			{
				return true;
			}
		}
		return false;
	});
	
});
