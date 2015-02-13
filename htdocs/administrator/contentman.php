<?php 
require_once('includes/_init.php'); 
require_once('helpers/paginator.class.php');
require_once('helpers/class.article.php');
require_once('helpers/class.category.php');
require_once('helpers/class.language.php');
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
			<h2> <?php echo $t->translate('content/view-title');?> </h2>	
				<div class="blockDistinct">
				<a href="add_article.php"><img src="images/new.png" alt="<?php echo $t->translate('content/content-new-name');?>" title="<?php echo $t->translate('content/content-new-name');?>"></a>
				<form style="display:inline;" action="<?php echo $PHP_SELF; ?>" method="get">
					<select name="c">
						<option value="all">All</option>
						<?php
						$cat_obj = new Category();
						$cat_obj->renderCategoriesAsOptions($_GET['c']);
						?>
					</select>
                    <select name="l">
                    <option value="all">All</option>
						<?php
						$lang_obj = new Language();
						$lang_obj->renderLanguageAsOptions($_GET['l']);
						?>
					</select>
					<input type="submit" value="<?php echo $t->translate('btn-filter'); ?>"/>
				</form>
				</div>
				<div class="block">
					
				<?php 
				$article_obj = new Article();
				//Find($category=0, $limit = null, $id = 0, $field='id',$order='desc',$language = 0)
				$available_articles = $article_obj->Find($_GET['c'],null,'all','id','desc',$_GET['l']);
				if(count($available_articles)>0):
					$pages = new Paginator(30);  
					$pages->items_total = count($available_articles);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$articles_full = $article_obj->Find($_GET['c'],null,'all','id','desc',$_GET['l']);
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('content/label-title')."</th><th>".$t->translate('language')."</th><th>".$t->translate('label-published')."</th><th>".$t->translate('label-homepage')."</th><th>".$t->translate('category/category-label')."</th><th>".$t->translate('posted-by')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($articles_full as $article):
						if($article->published==1):
							$pub_image = '<img src="images/tick.png" />';
						else:
							$pub_image = '<img src="images/untick.png" />';
						endif;
						if($article->homepage==1):
							$home_image = '<img src="images/tick.png" />';
						else:
							$home_image = '<img src="images/untick.png" />';
						endif;
						$actions = '<a href="edit_article.php?article='.$article->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="process_article.php?action=delete&article='.$article->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($article->title))."','$article->id')\">".$t->translate('delete').'</a>';
						print "<tr><td>$article->title</td><td>$article->language</td><td>$pub_image</td><td>$home_image</td><td>$article->category_name</td><td>$article->username</td><td>$actions</td>";
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