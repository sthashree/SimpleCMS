<?php 
require_once('includes/_init.php'); 
require_once('helpers/paginator.class.php');
require_once('helpers/class.event.php');
require_once('helpers/utility_functions.php');

	$objEvent = new Event();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			ユアーズ
		</title>
        
        <link rel="shortcut icon" href="../images/favicon.ico">
        
		<script type="text/javascript" src="js/nicedit.js"></script>
		<?php require_once('includes/_meta.php'); ?>
		<?php require_once('includes/_unotification.php'); ?>	       
		<?php require_once('includes/_anotification.php'); ?>
	</head>
	<body>
		<div id="topOfPage">
			<a name="topOfPage">&nbsp;</a>
		</div>
		
		<div id="conteiner">
			
			<?php require_once('includes/_header.php'); ?>
			
			<?php require_once('includes/_menu.php'); ?>

			<div id="body">		
				<?php $page = "events/".$_GET['extra'].".php";
				include_once($page);
				 ?>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>