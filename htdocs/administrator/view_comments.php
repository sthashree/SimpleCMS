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
include_once("../helpers/class.translation.php");
include_once("../helpers/class.article.php");
include_once("../helpers/class.category.php");
include_once("../helpers/class.blog.php");
include_once("../helpers/ajax.paginator.class.php");
$t = new Translation($_SESSION['language']);

?>