<?php 
require_once('includes/_init.php'); 
require_once(ADMINPATH.'helpers/paginator.class.php');
require_once(ADMINPATH.'helpers/class.category.php');
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
			<h2> <?php echo $t->translate('category/view-title');?> </h2>	
				<div class="blockDistinct">
				<a href="add_category.php"><img src="images/new.png" alt="<?php echo $t->translate('category/category-new-name');?>" title="<?php echo $t->translate('category/category-new-name');?>"></a>
				</div>
				<div class="block">
					
				<?php 
				$cat_obj = new Category();
				$available_categories = $cat_obj->Find();
				if(count($available_categories)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_categories);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$categories_full = $cat_obj->Find($pages->limit,'all');
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('category/category-label')."</th><th>".$t->translate('label-unique-name')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($categories_full as $category):
						$actions = '<a href="edit_category.php?category='.$category->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="process_category.php?action=delete&category='.$category->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($category->category_name))."','$category->id')\">".$t->translate('delete').'</a>';
						print "<tr><td>$category->category_name</td><td>$category->category_unique_name</td><td>$actions</td>";
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