<?php 
require_once('includes/_init.php'); 
require_once('helpers/paginator.class.php');
include_once(ADMINPATH.'/helpers/class.positionhelper.php');
if(is_null($p)){
$p = new PositionHelper('../layout.xml');
}
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
			<h2> <?php echo $t->translate('menu/view-title');?> </h2>	
				<div class="blockDistinct">
				<a href="add_menu.php"><img src="images/new.png" alt="<?php echo $t->translate('menu/menu-new-name');?>" title="<?php echo $t->translate('menu/menu-new-name');?>"></a>
				</div>
				<div class="block">
				<?php 
				if(count($available_menu)>0):
					$pages = new Paginator(10);  
					$pages->items_total = count($available_menu);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$menu_full = $m->Find($pages->limit,'all');
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('menu/label-mod-name')."</th><th>".$t->translate('label-unique-name')."</th><th>".$t->translate('label-published')."</th><th>".$t->translate('menu/label-position')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($menu_full as $menu):
						if($menu->published==1):
							$pub_image = '<img src="images/tick.png" />';
						else:
							$pub_image = '<img src="images/untick.png" />';
						endif;
						$actions = '<a href="edit_menu.php?menu='.$menu->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="process_menu.php?action=delete&menu='.$menu->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($menu->menu_name))."','$menu->id')\">".$t->translate('delete').'</a>';
						print "<tr><td><a href=\"menu-items.php?menu=$menu->id\">$menu->menu_name [<b>$menu->abbr</b>]</a></td><td>$menu->menu_unique_name</td><td>$pub_image</td><td>".$p->getPositionById($menu->position)."</td><td>$actions</td>";
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