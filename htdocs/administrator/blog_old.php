<?php 
require_once('includes/_init.php'); 
require_once('helpers/paginator.class.php');
require_once('helpers/class.blog.php');
require_once('helpers/utility_functions.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			ユアーズ
		</title>
        
        <link rel="shortcut icon" href="../images/favicon.ico">
		<?php require_once('includes/_meta.php'); ?>
        
		<link rel="stylesheet" href="<?=ADMINURL;?>css/facebox.css" type="text/css" />			
		<script language="JavaScript" type="text/javascript" src="<?=ADMINURL;?>js/facebox.js"></script>
		<script language="JavaScript" type="text/javascript" src="<?=ADMINURL;?>blog/js/helper.js" >
		<script language="JavaScript" type="text/javascript" src="<?=ADMINURL;?>js/niceedit.js" ></script></script>
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
			<h2> <?php echo $t->translate('blog/myblog');?> </h2>	
				<div class="blockDistinct">
				<a href="blog.php?extra=addcategory"><img src="images/category_new.png" height="40" alt="<?php echo $t->translate('myblog/add');?>" title="<?php echo $t->translate('myblog/add');?>"></a>
                <a href="blog.php?extra=viewtitle"><img src="images/category_icon.jpg" height="40" alt="<?php echo $t->translate('mygallery/gallery-list');?>" title="<?php echo $t->translate('myblog/blog-list');?>"></a>
				<a href="blog.php?extra=addtitle"><img src="images/new.png" height="40" alt="<?php echo $t->translate('myblog/add');?>" title="<?php echo $t->translate('myblog/add');?>"></a>
                <a href="blog.php?extra=viewtitle"><img src="images/gallery.gif" height="40" alt="<?php echo $t->translate('mygallery/gallery-list');?>" title="<?php echo $t->translate('myblog/blog-list');?>"></a>
				</div>
                
				<?php $page = "blog/".$_GET['extra'].".php";
				include_once($page);
				 ?>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>