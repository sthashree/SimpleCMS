<?php 
require_once('includes/_init.php'); 
require_once('helpers/paginator.class.php');
require_once("helpers/class.language.php");
$l = new Language();
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
			<h2> <?php echo $t->translate('language/language-man-name');?> </h2>	
				<div class="blockDistinct">
				<a href="add_language.php"><img src="images/new.png" alt="<?php echo $t->translate('language/language-new-name');?>" title="<?php echo $t->translate('language/language-new-name');?>"></a>
				</div>
				<div class="block">
				<?php 
				$available_language = $l->Find();
				//print "sadasd".count($available_language);
				if(count($available_language)>0):
					$pages = new Paginator(10);  
					$pages->items_total = count($available_language);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$lang_full = $l->Find($pages->limit,'all');
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('language/label-name')."</th><th>".$t->translate('language/label-abbrebiation')."</th><th>".$t->translate('label-published')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($lang_full as $lng):
						if($lng->published==1):
							$pub_image = '<img src="images/tick.png" />';
						else:
							$pub_image = '<img src="images/untick.png" />';
						endif;
						$actions = '<a href="edit_language.php?language='.$lng->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="process_language.php?action=delete&language='.$lng->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($lng->language))."','$menu->id')\">".$t->translate('delete').'</a>';
						print "<tr><td>$lng->language</a></td><td>$lng->abbr&nbsp&nbsp;<img src=\"../images/$lng->logo\" width=\"16\"></td><td><a href='process_language.php?action=publish&language=".$lng->id."&stat=".$lng->published."'>$pub_image</a></td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>