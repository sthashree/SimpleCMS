<?php
$t = new Translation($_SESSION['language']);
include_once(ADMINPATH."helpers/class.users.php");
$objBlog = new Blog();
$objUser = new Users();
						
$id=$_GET['id'];

$title_cat = $objBlog->FindTitle("","",$id);
$category_id = $title_cat->category_id;
?>

<script type="text/javascript">
function publishComment(status,comment_id,id) {
	//alert(23);
	$.ajax({
				type: "POST",
				url: "blog/action_comments.php",
				data: "action=publish&id="+id+"&status="+status+"&comment_id="+comment_id,
				success: function(data){
					//alert(data);
					$("#publish_"+comment_id).html(data);
				}
		 });
	return false;
}
</script>

<?php 
				echo "Topic:".$title_cat->title;
				$where = "blog_id='$id'";
				$comments=$objBlog->SearchComment($where);
				//var_dump($comments);
				if(count($comments)>0):
					$pages = new Paginator(10);  
					$pages->items_total = count($comments);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$articles_full = $objBlog->FindComment($id,$pages->limit, '','t.id','desc',$lang);
					print "<table class=\"datatable\" width=\"750px\">
					<thead><tr><th width=\"20%\">".$t->translate('myblog/name')."</th><th width=\"50%\">".$t->translate('content/label-title')."</th><th width=\"10%\">".$t->translate('label-published')."</th><th width=\"20%\">".$t->translate('content/label-modified-on')."</th></tr></thead>
					";
					foreach($articles_full as $article):
					$name=$article->name;
					if($article->name=="") {
						$user = $objUser->Find($article->user_id);
						$name = $user->username;	
						
					}
						if($article->published==1):
							$pub_image = '<a href"#" onclick="return publishComment(0,'.$article->id.','.$id.');"><img src="images/tick.png" /></a>';
						else:
							$pub_image = '<a href"#" onclick="return publishComment(1,'.$article->id.','.$id.');"><img src="images/untick.png" /></a>';
						endif;
						print "<tr><td id='name'>$name</td><td><a href=\"#\" onclick=\"return selectArticle('".addslashes(trim($article->title))."','$article->id')\">$article->comment</a></td><td><span id=\"publish_$article->id\" >$pub_image </span></td><td>$article->commented_date</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
				endif;
?>