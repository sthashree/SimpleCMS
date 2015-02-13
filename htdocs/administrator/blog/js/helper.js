// JavaScript Document
	function viewCategory(item) {
				itemVal=item.value;
			//	alert(itemVal);
				document.location='blog.php?extra=viewtitle&category='+itemVal;
			}
			
			$(function(){
	
	$("#btnSelect").click(function(){
		$.get('view_articles.php',{id:$("#id").val()},function(data) {
    		jQuery.facebox("<div id=\"article-container\">" + data + "</div>" )
		return false;
  		});
	});
					   });
			
	/*function showComments(id){
		$.ajax({
				type: "POST",
				url: "blog/view_comments.php",
				data: "id="+id,
				success: function(data){
					jQuery.facebox("<div id=\"article-container\">" + data + "</div>" )
					return false;
				}
		 });
	}
	*/
	