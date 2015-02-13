<?php
	//authorize the user and then allow the method
   include('../includes/_session.php');
   include_once('../helpers/class.movie.php');
   include_once('../helpers/utility_functions.php');
   $data = $_POST['data'];
  include_once('../helpers/class.language.php');
   $objLang=new Language();
   $action = $_REQUEST['action'];
  	$data['user_id'] = base64_decode($_SESSION['user_id']);
   $data['language_id'] = $objLang->getId($_SESSION['language']);
   //var_dump($_SESSION);
    //var_dump($data);
	//die;
   //$data = trim_array($data);
   include('../includes/_filter.php');
   switch($action)
   {
   		case 'finalmovie':
				
				  	$movie = new Movie($data);
				  	
					if($movie->Save())
					{
						header("Location: ../movie.php?extra=viewmovie&status=u-success");
					}
					else
					{
						header("Location: ../movie.php?extra=viewmovie&status=u-failed");
					}
				  
				  break;
				  
		case 'delete':
					if(intval($_GET['movie'])){
						$movie = new Movie($data);
				  	
						if($movie->Delete($_GET['movie']))
						{
							header("Location: ../movie.php?extra=viewmovie&status=d-success");
						}
						else
						{
							header("Location: ../movie.php?extra=viewmovie&status=d-failed");
						}
					}
					else{
						header("Location: ../movie.php?extra=viewmovie&status=invalid");
					}
					break;
		
			
   }

?>