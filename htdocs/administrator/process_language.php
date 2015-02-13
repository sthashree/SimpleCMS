<?php
	//authorize the user and then allow the method
   include('includes/_session.php');
   include_once('helpers/class.language.php');
   include_once('helpers/class.imageupload.php');
   include_once('helpers/utility_functions.php');
   $data = $_POST['data']['Language'];
   $action = $_REQUEST['action'];
   include('includes/_filter.php');
   $logo = $_FILES['logo'];
   /*
   print "<pre>";
   print_r($data);
   print_r($logo);
   print "</pre>";
  */
   switch($action)
   {
   		case 'add':
				  if( validate( $data, array( array('name'=>'language','type'=>'string'), array('name'=>'abbr','type'=>'string') ) ) )
				  {
				  	
				  	if($logo['error']==0)
					{
						$ext = end(preg_split('/\./', $logo['name']));
						$img_upload = new ImageUpload($logo,strtolower($data['abbr']).".".$ext);
						$img_upload->upload_dir = "../images/";
						$status = $img_upload->upload();
						$data = array_merge($data, array('logo'=>$status['UPLOAD_FILE_NAME']));
					}
				  	$language = new Language($data);
					if($language->Save())
					{
						header("Location: add_language.php?status=success");
					}
					else
					{
						@unlink($img_upload->upload_dir.strtolower($data['abbr']).".".$ext);
						header("Location: add_language.php?status=failed");
					}
				  }
				  else
				  {
				  	header("Location: add_language.php?status=invalid");
				  }
				  break;
		case 'update':
				  if( validate( $data, array( array('name'=>'language','type'=>'string'), array('name'=>'abbr','type'=>'string') ) ) )
				  {
				  	if($logo['error']==0)
					{
						$ext = end(preg_split('/\./', $logo['name']));
						$img_upload = new ImageUpload($logo,strtolower($data['abbr']).".".$ext);
						$img_upload->upload_dir = "../images/";
						$status = $img_upload->upload();
						if($status['UPLOAD_OK'])
						{
							$data = array_merge($data, array('logo'=>$status['UPLOAD_FILE_NAME']));
						}
					}
				  	$l = new Language($data);
					if($l->Save($_POST['language']))
					{
						header("Location: languages.php?status=u-success");
					}
					else
					{
						header("Location: languages.php?status=u-failed");
					}
				  }
				  else
				  {
				  	header("Location: languages.php?status=invalid");
				  }
				  break;
		case 'delete':
					if(intval($_GET['language'])>0){
						$l = new Language();
						$lang = $l->Find(null,$_GET['language']);
						if(!empty($lang->logo)){@unlink("../images/".$lang->logo);}
						if($l->Delete($_GET['language']))
						{
							header("Location: languages.php?status=d-success");
						}
						else
						{
							header("Location: languages.php?status=d-failed");
						}
					}
					else{
						header("Location: languages.php?status=invalid");
					}
					break;
	
		case 'publish':
			if(intval($_GET['language'])>0){
						$l = new Language();
						$lang = $l->Find(null,$_GET['language']);
						if(!empty($lang->logo)){@unlink("../images/".$lang->logo);}
						$stat=1-$_GET['stat'];
						if($l->Publish($_GET['language'],$stat))
						{
							header("Location: languages.php?status=p-success");
						}
						else
						{
							header("Location: languages.php?status=p-failed");
						}
					}
					else{
						header("Location: languages.php?status=invalid");
					}
					break;
			
   }

?>