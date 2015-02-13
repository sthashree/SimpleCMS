<?php
include("../helpers/config.php");
$uploaddir = './uploads/'; 
 
      include_once('../helpers/class.imageupload.php');
   //$name = $_FILES['uploadfile']['name'];
		$imageUpload = new ImageUpload($_FILES['uploadfile'],1,$uploaddir);
	$name = $imageUpload->getNewName($_FILES['uploadfile']['name']);	//$imageUpload->upload();
		
$file = $uploaddir . $name; 
$size=$_FILES['uploadfile']['size'];
if($size>504857600)
{
	echo "error file size > 100 MB";
	unlink($_FILES['uploadfile']['tmp_name']);
	unlink($uploaddir.$name);
	exit;
}
else {
	//move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file);
	//$imageUpload = $imageUpload->upload();
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file))
	 {
	//$name = $imageUpload->newName;
	//$imageUpload->createthumb();
	
	  global $CONN_STRING,$USER_NAME,$PWD;
						$conn = new PDO($CONN_STRING,$USER_NAME,$PWD);
						$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						$conn->query("SET CHARACTER SET utf8");
						$conn->query("SET SESSION collation_connection='utf8_general_ci'");
			
	  $sql = "insert into stha_chirasi(photo) values('$name')";
	  $result = $conn->query(trim($sql));
	  echo "success"; 
	} 
	/*else {
	echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
	}*/
}
?>