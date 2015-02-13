<div class="shoppingCartDetail">

<h2><?=$t->translate("myproduct/shoppingcart"); ?></h2>
<p><?=$t->translate("myproduct/ItemsOnCart"); ?></p>

<?php
//var_dump($_GET);
include_once(BASEPATH.'/administrator/helpers/class.cart.php');
$objCart=new cart();

	$cart_id = mysql_escape_string($_GET['cartId']);
	$products = $objCart->getProductByCart($cart_id,1);
	//var_dump($products);
	echo "<table border='0' width='100%'>";
	echo "<table border='0' width='100%'>";
	?>
    <tr class="heading">
    <td width="6%"><strong><?=$t->translate("serial");?></strong></td>
    <td><strong> <?=$t->translate("myproduct/product-title");?> </strong></td>
    <td><strong><?=$t->translate("myproduct/product");?></strong></td>
    
    </tr>
    
    <?php
	$i=1;
	foreach($products as $product) {
		if($i%2==0) $class="first";
		else $class="second";
	echo "<tr class='shoppingCart ". $class."'><td>".$i.".</td> ";
	echo "<td width='70%'><a href='product.php?extra=viewproduct'><strong>".$product->productname."</strong></a></td>";
	echo "<td>".$product->quantity."</td>";
	echo "</tr>";	
	$i++;
	}
	
	echo "</table>";
	$user_id = $product->user_id;
	
	$address = $objCart->FindDeliveryAddress($user_id);
?>
</div>
<div class="deliveryAddress"> <h2> <?=$t->translate("myproduct/deliveryaddress"); ?> </h2>

<form action="<?=BASEURL;?>product/sendmail.php" method="post" name="delivery-form" id="delivery-form" enctype="multipart/form-data">

	<div>
			<label for="title" class="required"><?php echo $t->translate('member/state'); ?></label>
			<?php echo $address->state; ?>
    </div>
    <br class="clear" />
    <div>    
        <label for="title" class="required"><?php echo $t->translate('member/city'); ?></label>
           <?php echo $address->city; ?>
            
  	</div>
    <br class="clear" />
    <div>
		<label for="title" class="required"><?php echo $t->translate('member/town'); ?></label>
		<?php echo $address->town; ?>
	</div>
    <br class="clear" />
    <div>
        <label for="short_description" class="required"><?php echo $t->translate('member/street'); ?></label>	
        <?php echo $address->street; ?>
            
    </div>
    <br class="clear" />
    <div>
    	<label for="title" class="required"><?php echo $t->translate('member/member-email'); ?></label>
		<?php echo $address->email; ?>
 	</div>
    <br class="clear" />
    <div>
		<label for="keywords" class="required"><?php echo $t->translate('member/mobile'); ?></label>
           <?php echo $address->mobile; ?>
 	</div>
    <br class="clear" />
    <div>           
		<label for="meta" class="required"><?php echo $t->translate('member/phone'); ?></label>
		<?php echo $address->phone; ?>
	</div>    	
</fieldset>

</form>

</div>
<script language="javascript">
	function deleteCart(prodId) {
		if(confirm("<?=$t->translate("myproduct/deltecart");?>")) {
		document.location='<?=BASEURL.$product->cartId;?>/product-processclearcart.htm';
		}

	}
</script>