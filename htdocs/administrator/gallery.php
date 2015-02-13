<?php 
require_once('includes/_init.php'); 
require_once('helpers/paginator.class.php');
require_once('helpers/class.gallery.php');
require_once('helpers/utility_functions.php');

	$gallery_obj = new Gallery();
	$gallery = $gallery_obj->Find(0,null,$_GET['gallery']);
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
		<?php require_once('includes/_anotification.php'); ?>
        
		<script language="JavaScript" type="text/javascript" src="js/nicedit.js"></script>
	</head>
	<body>
		<div id="topOfPage">
			<a name="topOfPage">&nbsp;</a>
		</div>
		
		<div id="conteiner">
			
			<?php require_once('includes/_header.php'); ?>
			
			<?php require_once('includes/_menu.php'); ?>

			<div id="body">		
			<h2> <?php echo $t->translate('mygallery/viewgallery');?> </h2>	
				<div class="blockDistinct">
				<a href="gallery.php?extra=configure"><img src="images/configure.png" height="40" alt="<?php echo $t->translate('mygallery/configure');?>" title="<?php echo $t->translate('mygallery/gallery-configure');?>"></a>
				<a href="gallery.php?extra=addgallery"><img src="images/new.png" height="40" alt="<?php echo $t->translate('mygallery/add');?>" title="<?php echo $t->translate('mygallery/add');?>"></a>
                <a href="gallery.php?extra=viewgallery"><img src="images/gallery.gif" height="40" alt="<?php echo $t->translate('mygallery/gallery-list');?>" title="<?php echo $t->translate('mygallery/gallery-list');?>"></a>
                <a href="gallery.php?extra=addphoto"><img src="images/add_photo.jpg" height="40" alt="<?php echo $t->translate('mygallery/photo-new');?>" title="<?php echo $t->translate('mygallery/photo-new');?>"></a>
                <a href="gallery.php?extra=viewphoto"><img src="images/view_photo.gif" height="40" alt="<?php echo $t->translate('mygallery/photo-list');?>" title="<?php echo $t->translate('mygallery/photo-list');?>"></a>
                                                
				</div>
				<?php $page = "gallery/".$_GET['extra'].".php";
				include_once($page);
				 ?>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>