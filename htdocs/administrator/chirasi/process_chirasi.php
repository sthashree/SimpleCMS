<?php
	echo "Test";
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.chirasi.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data'];
   $file = $_FILES['data'];
   //var_dump($_FILES['data']);
  // var_dump($file);
   //die;
   //var_dump($data);
  $action = $_REQUEST['action'];
   //$data[1]['user_id'] = base64_decode($_SESSION['user_id']);
   //$data = trim_array($data);
   include('../includes/_filter.php');
   switch($action)
   {
   			
   		case 'finalchirasi':
				
				  	$gallery = new Chirasi($data);
				  	
					if($gallery->Save())
					{
						header("Location: ../chirasi.php?extra=chirasi&status=u-success");
					}
					else
					{
						header("Location: ../chirasi.php?extra=chirasi&status=u-failed");
					}
				  
				  break;
				
		case 'editchirasi':
		
				
				  	$gallery = new Chirasi($data,$file);
					$chirasiId=$_POST['chirasiId'];
				  	
					if($gallery->Save($chirasiId))
					{
						header("Location: ../chirasi.php?extra=chirasi&status=u-success");
					}
					else
					{
						header("Location: ../chirasi.php?extra=chirasi&status=u-failed");
					}
				  
				  break;		
				  
		case 'delete':
					if(intval($_GET['photo'])){
						$gallery = new Chirasi($data,$file);
						if($gallery->Delete($_GET['photo']))
						{
							header("Location: ../chirasi.php?extra=chirasi&status=d-success");
						}
						else
						{
							header("Location: ../chirasi.php?extra=chirasi&status=d-failed");
						}
					}
					else{
						header("Location: ../chirasi.php?extra=chirasi&status=invalid");
					}
					break;
		
			
   }

?>