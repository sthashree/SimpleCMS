// JavaScript Document

function updateCategory(item) {
		vals=item.value;
		$("#category").val(vals);
	}
	
	function submitform(frmid) {
			document.forms[""+frmid+""].submit();

		
	}
	function showMonth($m) {
	$("#months_"+$m).toggle("slow");	
	return false;
}