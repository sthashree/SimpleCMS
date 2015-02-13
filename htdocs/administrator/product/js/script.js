// JavaScript Document

function selectSub() {
	cat = $("#category").val();
	//alert(cat);
	$.ajax({
   		type: "POST",
   		url: "product/getSubcat.php",
   		data: "id="+cat,
   		success: function(msg){
			$("#subcat").html(msg);
		}
	 });
}