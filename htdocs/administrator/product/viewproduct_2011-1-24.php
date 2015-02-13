			
		<script language="JavaScript" type="text/javascript" src="../js/facebox.js"></script>
		<script language="JavaScript" type="text/javascript" src="js/product.helper.js"></script>
            <div id="body">		
			<h2> <?php echo $t->translate('myproduct/viewproducts');?> </h2>	
				<div class="blockDistinct">
				<a href="product.php?extra=addproduct"><img src="images/new.png" alt="<?php echo $t->translate('myproduct/new-event');?>" title="<?php echo $t->translate('product/new-product');?>"></a>
				</div>
				<div class="block">
					
				<?php 
				$productObj = new Product();
				$available_products = $productObj->FindProduct();
				//var_dump($available_products);
				//echo count($available_members);
				//die;
				if(count($available_products)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_products);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$products_full = $productObj->FindProduct();
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('myproduct/product-title')."</th><th>".$t->translate('myproduct/category')."</th><th>".$t->translate('myproduct/subcategory')."</th><th>".$t->translate('myproduct/todaySpecial')."</th><th>".$t->translate('myproduct/featured')."</th><th>".$t->translate('action')."</th></tr></thead>";
					foreach($products_full as $product):
						$actions = '<a href="product.php?extra=editproduct&product='.$product->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="product/process_product.php?action=deleteProduct&product='.$product->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($product->product_title))."','$product->id')\">".$t->translate('delete').'</a><a id="viewComment">'.$t->translate('comment').'</a>';
						$parents=$productObj->getParentCategory($product->category_id);
						print "<tr><td>".$product->product_title."</td><td>".$parents['category']."</td><td>".$parents['subcategory']."</td><td>".$product->todaySpecial."</td><td>".$product->isfeatured."</td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
			</div>

		