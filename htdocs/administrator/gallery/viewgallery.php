<h2> <?php echo $t->translate('mygallery/configure');?> </h2>	
				<div class="block">
					
				<?php 
				$gallery = new Gallery();
				$available_gallery = $gallery->Find();
				//echo count($available_gallery);
				//die;
				if(count($available_gallery)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_galllery);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$gallery_full = $gallery->Find();
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('mygallery/gallery-label')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($gallery_full as $gal):
						$actions = '<a href="gallery.php?extra=editgallery&gallery='.$gal->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="gallery/process_gallery.php?action=delete&gallery='.$gal->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($gal->gallery_name))."','$gal->id')\">".$t->translate('delete').'</a>';
						print "<tr><td>".$gal->gallery_name."</td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
