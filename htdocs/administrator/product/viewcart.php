<?php

$cartObj = new Cart();
if($_GET['action']=="publish") {
	$cartObj->delivered($_GET['title'],$_GET['stat']);	
}

?>

<h2> <?php echo $t->translate('cart');?> </h2>	

				<div class="block">
					
				<?php 
				$availableCarts = $cartObj->getConfirmedCart();
				//echo count($available_gallery);
				//die;
				if(count($availableCarts)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($availableCarts);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$carts = $cartObj->getConfirmedCart();
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('myproduct/category')."</th><th>".$t->translate('label-order')."</th><th>".$t->translate('action')."</th><th>".$t->translate('view-more')."</tr></thead>";
					foreach($carts as $cart):
					if($cart->delivered==1):
							$pub_image = '<img src="images/tick.png" />';
						else:
							$pub_image = '<img src="images/untick.png" />';
						endif;
						print "<tr><td  style='text-align:left'>".$cart->firstname."</td><td width='10%'>".$totalItem."</td><td><a href='product.php?extra=viewcart&action=publish&title=".$cart->id."&stat=".(1-$cart->delivered)."'>$pub_image</a></td><td><a href='product.php?extra=cartDetail&cartId=$cart->id'>".$t->translate('view-more')."</a>  </td>";
							
	
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				
				?>
				</div>
