
        
            	<div class="blockDistinct">
				</div>
				<div class="block">
                
        <div class="leftCategory">
        	<?php
				
					if(isset($_GET['category'])) { $category=$_GET['category']; }
				$objBlog = new Blog();
				$available_blogs = $objBlog->Find();
				//var_dump($available_blogs);
            ?><form name="frmBlogCategory" method="post" action="#" >
            	<ul> <h3><?=$t->translate("myblog/category-list");?></h3>
                <?php foreach($available_blogs as $blog) {  ?>
                	
                	<li><input onclick="viewCategory(this)" type="radio" name="category" <?php if($category==$blog->id) { ?> checked="checked" <?php } ?> value="<?=$blog->id;?>" /><?=$blog->category_name;?></li>
             	<?php } ?>    
              	</ul>
                </form>
            </div>	
            <div class="rightCategory">
					
				<?php 
				
				$available_products = $objBlog->FindTitle($category);
				//var_dump($available_products);
				//echo count($available_members);
				//die;
				if(count($available_products)>0){
					$pages = new Paginator(20);  
					$pages->items_total = count($available_products);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$products_full = $objBlog->FindTitle($category);
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('myblog/blog-topic')."</th><th>".$t->translate('myblog/category')."</th><th>".$t->translate('myblog/published')."</th><th>".$t->translate('action')."</th></tr></thead>";
					foreach($products_full as $product):
					if($product->published==1):
							$pub_image = '<img src="images/tick.png" />';
						else:
							$pub_image = '<img src="images/untick.png" />';
						endif;
						$actions = '<a href="blog.php?extra=edittitle&blog='.$product->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="blog/process_title.php?action=deleteTitle&blog='.$product->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($product->title))."','$product->id')\">".$t->translate('delete').'</a><a href="blog.php?extra=view_comments&id='.$product->id.'"><input type="button" onclick="window.location=blog.php?extra=view_comments" value="'.$t->translate('comment').'"/></a><input type="hidden" name="id" value="'.$product->id.'" />';
						$parents=$objBlog->getParentCategory($product->category_id);
						print "<tr><td>".$product->title."</td><td>".$parents['category']."</td><td><a href='blog/process_title.php?action=publish&title=".$product->id."&stat=".$product->published."'>$pub_image</a></td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				}
				else {
					echo "No Topics "; 
					}
				?>
                </div>
				</div>

		