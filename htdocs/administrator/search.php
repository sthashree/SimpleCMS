<?php 
require_once('includes/_init.php'); 
include_once(ADMINPATH.'/helpers/class.article.php'); 
include_once(ADMINPATH.'/helpers/paginator.class.php'); 
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
					
					
					<?php
					$article_obj = new Article();
					$articles = $article_obj->Search($_REQUEST['q']);
					if(count($articles)>0)
					{
					$pages = new Paginator(10);  
					$pages->items_total = count($articles);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$articles_ = $article_obj->Search($_REQUEST['q'],$pages->limit);
					print "<h2>".$t->translate('search-result-label')." \" ".$_REQUEST['q']." \"</h2>";
					foreach($articles_ as $article):
					 ?>
					<div class="record">
			        <div class="content">
			        <span class="title"><?php echo $article->title; ?></span>
					<span class="author"><?php echo $article->short_description; ?></span>
			        <span class="author"><?php echo $t->translate("posted-by"); ?> : <?php echo $article->username; ?></span>
			        <span class="author"><?php echo $t->translate('last-modified'); ?> : <?php echo $article->modified_date; ?></span>
					<span class="author">
			          <a href="edit_article.php?article=<?php echo $article->id; ?>"><?php echo $t->translate("edit"); ?></a> |
			         <a href="process_article.php?action=delete&article=<?php echo $article->id; ?>" onclick="return confirmDelete('<?php echo trim(addslashes($article->title)); ?>','<?php echo $article->id; ?>')"><?php echo $t->translate("delete"); ?></a> 
			        </span>			        
			        </div>
			        <div class="clear-floats"></div>
			      </div>
				  <?php
				  endforeach;
				  echo $pages->display_pages();
					echo  $pages->display_items_per_page();
					}
					else{
						print "<h2>".$t->translate('search-result-label')." \" ".$_REQUEST['q']." \"</h2>";
						?>
						<div class="record">
				        <div class="content">
				        <span class="title"><font color="red"><?php echo $t->translate('no-result-label');?></font></span>
						</div>
						</div>
					<?php
					}
				  ?>
					<!--
				<div class="block">
sdfsdfsdf
				</div>-->
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>