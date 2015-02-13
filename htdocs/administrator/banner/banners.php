			<div id="body">	
            	
			<h2> <?php echo $t->translate('banner/viewbanner');?> </h2>	
				<div class="blockDistinct">
				<a href="banner.php?extra=add_banner"><img src="images/new.png" alt="<?php echo $t->translate('event/new-event');?>" title="<?php echo $t->translate('banner/new-banner');?>"></a>
				</div>
				<div class="block">
					
				<?php 
				$objBanner = new Banner();
				$available_banners = $objBanner->Find();
				
				//echo count($available_members);
				//die;
				if(count($available_banners)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_banners);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$page=1;
					$ipp=20;
					$page=$_GET['page'];
					$ipp=$_GET['ipp'];
					$limit="";
					if($page!="" && $ipp!="All") { 
						$start=($page-1)*$ipp;
						$limit=" limit ".$start." , ".$ipp;
					}
					$banners_full = $objBanner->Find("",$limit);
					print "<form name=\"reorder\" action=\"banner/process_banner.php\" method=\"post\"><input type=\"submit\" value=\"".$t->translate('Front/save-order')."\"><table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('banner/banner-title')."</th><th>".$t->translate('banner/image')."</th><th>".$t->translate('banner/description')."</th><th width=\"30\">".$t->translate('order')."</th><th width=\"63\">".$t->translate('action')."</th></tr></thead>
					";
					foreach($banners_full as $banner):
						$actions = '<a href="banner.php?extra=edit_banner&banner='.$banner->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="banner/process_banner.php?action=delete&banner='.$banner->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($banner->title))."','$banner->id')\">".$t->translate('delete').'</a>';
						print "<tr><td>".$banner->title."</td><td><img src=\"".ADMINURL."banner/photo/".$banner->image."\" alt=\"".$banner->title."\" width=\"300\"></td><td>".$banner->description."</td><td><input type=\"text\" name=\"order[".$banner->id."]\" value=\"".$banner->ordering."\" size=\"1\"  /></td><td>$actions</td>";
					endforeach;
					print "</table><input type=\"hidden\" name=\"action\" value=\"saveorder\"  /></form>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
			</div>

		