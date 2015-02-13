<?php

include("../helpers/config.php");
$uploaddir = './movie/'; 
 
   include_once('../helpers/class.imageupload.php');
		$imageUpload = new ImageUpload($_FILES['uploadfile'],1,$uploaddir,$_FILES['uploadfile']['name']);
	$name = $imageUpload->getNewName();
$file = $uploaddir . $_FILES['uploadfile']['name']; 
$size=$_FILES['uploadfile']['size'];
if($size>104857600)
{
	echo "error file size > 1 MB";
	unlink($_FILES['uploadfile']['tmp_name']);
	exit;
}
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {

//$imageUpload->createthumb();

  global $CONN_STRING,$USER_NAME,$PWD;
					$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$conn->query("SET CHARACTER SET utf8");
					$conn->query("SET SESSION collation_connection='utf8_general_ci'");
		
  $name= $_FILES['uploadfile']['name'];
  $sql = "insert into stha_movie(link) values('$name')";
  $result = $conn->query(trim($sql));
  echo "success"; 
} else {
	echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
}
?>