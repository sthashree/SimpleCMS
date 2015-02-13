<?php
    @session_name('session_admin');
	@session_start();
	if(!isset($_SESSION['user_id']) && intval($_SESSION['user_id'])<=0)
	{
		@session_destroy();
		header("Location: login.php");
	}
?>