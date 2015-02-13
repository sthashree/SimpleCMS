	
				<div class="block">
					
				<?php 
				$objBlog = new Blog();
				$available_gallery = $objBlog->Find();
				//echo count($available_gallery);
				//die;
				if(count($available_gallery)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_galllery);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$gallery_full = $objBlog->Find();
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('myblog/category-title')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($gallery_full as $gal):
						$actions = '<a href="blog.php?extra=editcategory&blog='.$gal->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="blog/process_blog.php?action=delete&blog='.$gal->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($gal->category_name))."','$gal->id')\">".$t->translate('delete').'</a>';
						print "<tr><td>".$gal->category_name."</td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
