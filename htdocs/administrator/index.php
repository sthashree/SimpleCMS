<?php 

require_once('includes/_init.php'); 
include_once(ADMINPATH.'/helpers/class.article.php'); 
include_once(ADMINPATH.'/helpers/class.category.php'); 
include_once(ADMINPATH.'/helpers/class.language.php'); 
include_once(ADMINPATH.'/helpers/class.menu.php'); 
include_once(ADMINPATH.'/helpers/class.positionhelper.php');
$p = new PositionHelper('../layout.xml');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			ユアーズ
		</title>
        
        <link rel="shortcut icon" href="../images/favicon.ico">
        
		<?php require_once('includes/_meta.php'); ?>
		<?php require_once('includes/_unotification.php'); ?>
	</head>
	<body>
		<div id="topOfPage">
			<a name="topOfPage">&nbsp;</a>
		</div>
		
		<div id="conteiner">
			
			<?php require_once('includes/_header.php'); ?>
			
			<?php require_once('includes/_menu.php'); ?>

			<div id="body">		
			
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>