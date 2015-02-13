<?php
include("helpers/config.php");
echo $gallery = $_GET['gallery'];

$uploaddir = './uploads/'; 
$name= $_FILES['uploadfile']['name'];
		
		//$ext=explode('.',$name);
		//$ext=$ext[count($ext)-1];
		//$new_name=time().".".$ext;

//$name = $imageUpload->getNewName($_FILES['uploadfile']['name']);
		$file = $uploaddir . $name;
//$file = $uploaddir . basename($_FILES['uploadfile']['name']); 
$size=$_FILES['uploadfile']['size'];
if($size>1048576)
{
	echo "error file size > 1 MB";
	unlink($_FILES['uploadfile']['tmp_name']);
	exit;
}
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 

 	
  	global $CONN_STRING,$USER_NAME,$PWD;
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
		
  
  
  $sql = "insert into stha_photo(photo,gallery_id) values('$name','$gallery')";
  $result = $conn->query(trim($sql));
  echo "success"; 
} else {
	echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
}
?>