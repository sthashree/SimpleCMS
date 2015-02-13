<?php
header("Cache-Control: no-cache");
header("Pragma: nocache");
@session_name('session_admin');
@session_start();
if(!isset($_SESSION['user_id']) && intval($_SESSION['user_id'])<=0)
	{
		@session_destroy();
		echo "err-420";
		exit;
	}
include_once("includes/_init.php");
include_once("helpers/class.translation.php");
include_once("helpers/class.article.php");
include_once("helpers/class.category.php");
include_once("helpers/class.menu.php");
include_once("helpers/ajax.paginator.class.php");
$t = new Translation($_SESSION['language']);
?>
<script language="JavaScript" type="text/javascript">
<!--
	
	$(function(){
		$("#view-article-form").submit(function(){
			loadArticles($(this).serialize());
		});
	});
-->	
</script>
<?php
$m = new Menu();
$menu = $m->Find(null,$_GET['m']);
$lang = empty($_GET['m'])?$_GET['l']:$menu->language_id;
?>
<form style="display:inline;" id="view-article-form" action="<?php echo $PHP_SELF; ?>" method="get">
					<select name="c" id="c">
						<option value="all">All</option>
						<?php
						$cat_obj = new Category();
						$cat_obj->renderCategoriesAsOptions($_GET['c']);
						?>
					</select>
                    <input type="hidden" name="l" value="<?php echo $lang; ?>"/>
					<input type="submit" value="<?php echo $t->translate('btn-filter'); ?>"/>
				</form>
<?php 
				$article_obj = new Article();
				$available_articles = $article_obj->Find($_GET['c'],null, 'all','t.id','desc',$lang);
				if(count($available_articles)>0):
					$pages = new Paginator(10);  
					$pages->items_total = count($available_articles);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$articles_full = $article_obj->Find($_GET['c'],$pages->limit, 'all','t.id','desc',$lang);
					print "<table class=\"datatable\" width=\"550px\">
					<thead><tr><th width=\"20%\">".$t->translate('content/label-modified-on')."</th><th width=\"40%\">".$t->translate('content/label-title')."</th><th width=\"10%\">".$t->translate('label-published')."</th><th width=\"10%\">".$t->translate('label-homepage')."</th><th width=\"20%\">".$t->translate('category/category-label')."</th></tr></thead>
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
						print "<tr><td>$article->modified_date</td><td><a href=\"#\" onclick=\"return selectArticle('".addslashes(trim($article->title))."','$article->id')\">$article->title</a></td><td>$pub_image</td><td>$home_image</td><td>$article->category_name</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
				endif;
?>