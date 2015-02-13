<?php
	$galleries = $gallery_obj->Find();
	$gallery = $_POST['gallery'];
?>
<h2> <?php echo $t->translate('mygallery/configure');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="#" method="post" name="add-gallery-form" id="add-gallery-form" enctype="multipart/form-data">
<fieldset>
	<label for="title" class="required"><?php echo $t->translate('mygallery/gallery-choose'); ?></label>
			<?php
				echo SelectList("gallery",$galleries,"gallery_name",$gallery,"this.form.submit()");
			?>
<div id="swfupload-control">
	<p>Upload upto 5 image files(jpg, png, gif), each having maximum size of 1MB</p>
	<input type="button" id="button" />
	<p id="queuestatus" ></p>
	<ol id="log"></ol>
</div>

</fieldset>
				</div>
<script type="text/javascript" src="js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="js/jquery.swfupload.js"></script>
<script type="text/javascript">

$(function(){
	var gallery = $("#gallery").val();
	//alert(gallery);
	$('#swfupload-control').swfupload({
		
		upload_url: "upload-file.php?gallery="+gallery,
		file_post_name: 'uploadfile',
		file_size_limit : "5000000",
		file_types : "*.jpg;*.png;*.gif",
		file_types_description : "Image files",
		file_upload_limit : 10,
		flash_url : "js/swfupload/swfupload.swf",
		button_image_url : 'js/swfupload/wdp_buttons_upload_114x29.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button')[0],
		debug: false
	})
		.bind('fileQueued', function(event, file){
			var listitem='<li id="'+file.id+'" >'+
				'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
				'<div class="progressbar" ><div class="progress" ></div></div>'+
				'<p class="status" >Pending</p>'+
				'<span class="cancel" >&nbsp;</span>'+
				'</li>';
			$('#log').append(listitem);
			$('li#'+file.id+' .cancel').bind('click', function(){
				var swfu = $.swfupload.getInstance('#swfupload-control');
				swfu.cancelUpload(file.id);
				$('li#'+file.id).slideUp('fast');
			});
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			alert('Size of the file '+file.name+' is greater than limit');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			$('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
		})
		.bind('uploadStart', function(event, file){
			$('#log li#'+file.id).find('p.status').text('Uploading...');
			$('#log li#'+file.id).find('span.progressvalue').text('0%');
			$('#log li#'+file.id).find('span.cancel').hide();
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//Show Progress
			var percentage=Math.round((bytesLoaded/file.size)*100);
			$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			var item=$('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			var pathtofile='<a href="uploads/'+file.name+'" target="_blank" >view &raquo;</a>';
			item.addClass('success').find('p.status').html('Done!!! | '+pathtofile);
		})
		.bind('uploadComplete', function(event, file){
			//redirect page after upload
			document.location='gallery.php?extra=finalphoto&gallery='+gallery;
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
		})
	
});	

</script>
<style type="text/css" >
#swfupload-control p{ margin:10px 5px; font-size:0.9em; }
#log{ margin:0; padding:0; width:500px;}
#log li{ list-style-position:inside; margin:2px; border:1px solid #ccc; padding:10px; font-size:12px; 
	font-family:Arial, Helvetica, sans-serif; color:#333; background:#fff; position:relative;}
#log li .progressbar{ border:1px solid #333; height:5px; background:#fff; }
#log li .progress{ background:#999; width:0%; height:5px; }
#log li p{ margin:0; line-height:18px; }
#log li.success{ border:1px solid #339933; background:#ccf9b9; }
#log li span.cancel{ position:absolute; top:5px; right:5px; width:20px; height:20px; 
	background:url('../js/swfupload/cancel.png') no-repeat; cursor:pointer; }
</style>