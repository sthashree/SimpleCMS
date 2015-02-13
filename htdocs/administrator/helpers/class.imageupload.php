<?php
class ImageUpload {
	
	var $upload_dir;
	var $thumbnail_dir ;
	var $_image = null;
	var $_filename = "";
	var $_thumb = 0;
	var $_allowed_file_type = array('image/jpeg','image/jpg','image/png','image/gif');
	var $_max_size = 10048000; //10mb
	
	var $_thumbWidth = 150;
	var $_thumbHeight = 150;
	var $_fullPath = "";
	var $_thumbPath = "";
	var $newName;
	
	function __construct($data,$thumb,$upload_dir='',$rename='')
	{
		if($upload_dir!="")
		{
			$this->upload_dir = $upload_dir;
			$this->thumbnail_dir = $upload_dir."/thumb/";
		}
		$this->_image = $data;
		$this->_filename = $this->getNewName($this->_image['name']);
		if(isset($rename) && $rename!="") $this->_filename = $rename;
		$this->_thumb = $thumb;
		echo $this->_fullPath = $this->upload_dir.$this->_filename;
		echo $this->_thumbPath = $this->thumbnail_dir.$this->_filename;
	//print $desired_filename;
	}
	
	function upload()
	{
		$status = array('UPLOAD_OK' =>FALSE,'UPLOAD_FILE_NAME'=>'default.gif');
		if(!is_null($this->_image))
		{
			if( $this->_image['error']==0 && in_array($this->_image['type'], $this->_allowed_file_type) &&  $this->_image['size'] <= $this->_max_size)
			{
				if(is_uploaded_file($this->_image['tmp_name']))
				{
					
					if(move_uploaded_file($this->_image['tmp_name'],$this->upload_dir.$this->_filename))
					{
					
						if($this->_thumb == 1)
						{
							$this->createThumb();
						}
						$status = array('UPLOAD_OK' =>TRUE,'UPLOAD_FILE_NAME'=>$this->_filename);
					}
				}
			}
		}
		return $status;
	}
	
	function getExtension($image)
	{
		$image_ext=explode(".",$image);
		$count=count($image_ext);
		return $image_ext[$count-1];	
	}
	
	function getNewName($image)
	{
		if(isset($image) && $image!="") $name =  $image;
		else $name = $this->_image['name'];
		$ext=explode('.',$name);
		$ext=$ext[count($ext)-1];
		$new_name=time().".".$ext;
		
		$this->newName = $new_name;
		return $this->newName;
	}
	
	function createthumb(){
	$system=explode('.',$this->_fullPath);
	$len=count($system);
	if (preg_match('/jpg|jpeg|JPG/',$system[$len-1])){
		$src_img=imagecreatefromjpeg($this->_fullPath);
		}
	if (preg_match('/GIF|gif/',$system[$len-1])){
		$src_img=imagecreatefromgif($this->_fullPath);
	}
	if (preg_match('/png/',$system[$len-1])){
		$src_img=imagecreatefrompng($this->_fullPath);
	}
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	if ($old_x > $old_y) {
		$thumb_w=$this->_thumbWidth;
		$thumb_h=$old_y*($this->_thumbHeight/$old_x);
	}
	if ($old_x < $old_y) {
		$thumb_w=$old_x*($this->_thumbWidth/$old_y);
		$thumb_h=$this->_thumbHeight;
	}
	if ($old_x == $old_y) {
		$thumb_h=$this->_thumbHeight;;
		$thumb_w=$this->_thumbWidth;
	}
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
	if (preg_match("/png/",$system[1]))
	{
		imagepng($dst_img,$this->_thumbPath); 
	} else {
		imagejpeg($dst_img,$this->_thumbPath); 
	}
	imagedestroy($dst_img); 
	imagedestroy($src_img); 
}

function resize($rewidth,$reheight,$dir){
	$system=explode('.',$this->_fullPath);
	$len=count($system);
	if (preg_match('/jpg|jpeg|JPG/',$system[$len-1])){
		$src_img=imagecreatefromjpeg($this->_fullPath);
		}
	if (preg_match('/GIF|gif/',$system[$len-1])){
		$src_img=imagecreatefromgif($this->_fullPath);
	}
	if (preg_match('/png/',$system[$len-1])){
		$src_img=imagecreatefrompng($this->_fullPath);
	}
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	if($old_x > $rewidth && $old_y > $reheight) {
	if ($old_x > $old_y) {
		$thumb_w=$rewidth;
		$thumb_h=$old_y*($reheight/$old_x);
	}
	if ($old_x < $old_y) {
		$thumb_w=$old_x*($rewidth/$old_y);
		$thumb_h=$reheight;
	}
	
	if ($old_x == $old_y) {
		$thumb_h=$reheight;
		$thumb_w=$rewidth;
	}
	}
	else {
	
		$thumb_h=$old_y;
		$thumb_w=$old_x;
	}
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
	if (preg_match("/png/",$system[1]))
	{
		imagepng($dst_img,$dir.$this->_filename); 
	} else {
		imagejpeg($dst_img,$dir.$this->_filename); 
	}
	imagedestroy($dst_img); 
	imagedestroy($src_img); 
}

	
	
}
?>