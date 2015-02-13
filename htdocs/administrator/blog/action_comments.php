<?php
header("Cache-Control: no-cache");
header("Pragma: nocache");
@session_name('session_admin');
@session_start();
if(!isset($_SESSION['user_id']) && intval($_SESSION['user_id'])<=0)
	{
		@session_destroy();
		echo "err-420";
		exit;
	}
include_once("../includes/_init.php");
include_once("../helpers/class.translation.php");
include_once("../helpers/class.blog.php");
include_once("../helpers/ajax.paginator.class.php");
$t = new Translation($_SESSION['language']);

$objBlog = new Blog();
	
$action = $_POST['action'];
$comment_id=$_POST['comment_id'];
$id=$_POST['id'];
switch($action) {
	case 'publish':
					$status=$_POST['status'];
					$objBlog->PublishComment($comment_id,$status);
					break;
					
	}
	 $comments = $objBlog->FindComment("","",$comment_id);			
	//var_dump($comments);
if($comments->published==1):
							$pub_image = '<a href"#" onclick="return publishComment(0,'.$comments->id.','.$id.');"><img src="images/tick.png" /></a>';
						else:
							$pub_image = '<a href"#" onclick="return publishComment(1,'.$comments->id.','.$id.');"><img src="images/untick.png" /></a>';
						endif;
echo $pub_image;
?>