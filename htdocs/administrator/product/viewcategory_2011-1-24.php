<h2> <?php echo $t->translate('myproduct/category');?> </h2>	
	<div class="blockDistinct">
		<a href="product.php?extra=addcategory"><img src="images/new.png" height="40" alt="<?php echo $t->translate('myproduct/addcategory');?>" title="<?php echo $t->translate('myproduct/addcategory');?>"></a>
 	</div>
				<div class="block">
					
				<?php 
				$productObj = new Product();
				$availableProducts = $productObj->Find();
				//echo count($available_gallery);
				//die;
				if(count($availableProducts)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_galllery);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$category_full = $productObj->Find('','','','ordering','asc');
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('myproduct/category')."</th><th>".$t->translate('order')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($category_full as $category):
						$actions = '<a href="product.php?extra=editcategory&category='.$category->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="product/process_category.php?action=deletecategory&category='.$category->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($category->category_name))."','$category->id')\">".$t->translate('delete').'</a>';
						print "<tr><td  style='text-align:left'>".$category->category_name."</td><td width='10%'>".$category->ordering."</td><td>$actions</td>";
							$category_child = $productObj->Find($category->id,'','','ordering','asc');
							foreach($category_child as $cat):
								$actions = '<a href="product.php?extra=editcategory&category='.$cat->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="product/process_category.php?action=deletecategory&category='.$cat->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($cat->category_name))."','$category->id')\">".$t->translate('delete').'</a>';
								print "<tr><td style='text-align:left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cat->category_name."</td><td width='10%'>".$cat->ordering."</td><td>$actions</td>";
	
							endforeach;
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				
				?>
				</div>
