<?php
	//authorize the user and then allow the method
   include('includes/_session.php');
   include_once('helpers/class.article.php');
   include_once('helpers/utility_functions.php');
   $data = $_POST['data']['Article'];
   $action = $_REQUEST['action'];
   $data['user_id'] = base64_decode($_SESSION['user_id']);
   $data = trim_array($data);
   include('includes/_filter.php');
   switch($action)
   {
   		case 'add':
				  if( validate( $data, array( array('name'=>'category_id','type'=>'numeric'), array('name'=>'title','type'=>'string'), array('name'=>'keywords','type'=>'string'), array('name'=>'short_description','type'=>'string'), array('name'=>'full_description','type'=>'string') ) ) )
				  {
				  	$article = new Article($data);
					if($article->Save())
					{
						header("Location: add_article.php?status=success");
					}
					else
					{
						header("Location: add_article.php?status=failed");
					}
				  }
				  else
				  {
				  	header("Location: add_article.php?status=invalid");
				  }
				  break;
		case 'update':
			
				  if( validate( $data, array( array('name'=>'category_id','type'=>'numeric'), array('name'=>'title','type'=>'string'), array('name'=>'keywords','type'=>'string'), array('name'=>'short_description','type'=>'string'), array('name'=>'full_description','type'=>'string') ) ) )
				  {
				  	$article = new Article($data);
					if($article->Save($_POST['article']))
					{
						header("Location: contentman.php?status=u-success");
					}
					else
					{
						header("Location: contentman.php?status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: contentman.php?status=invalid");
				  }
				  break;
		case 'delete':
					if(intval($_GET['article'])){
						$article = new Article($data);
						if($article->Delete($_GET['article']))
						{
							header("Location: contentman.php?status=d-success");
						}
						else
						{
							header("Location: contentman.php?status=d-failed");
						}
					}
					else{
						header("Location: contentman.php?status=invalid");
					}
					break;
   }

?>