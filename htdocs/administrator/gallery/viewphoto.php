<?php
	$galleries = $gallery_obj->Find();
	$gallery = makeclean($_POST['gallery']);
?>
<h2> <?php echo $t->translate('mygallery/configure');?> </h2>	
				<div class="block">
					<form style="display:inline;" action="gallery.php?extra=viewphoto" method="post">
					<?php
                        echo SelectList("gallery",$galleries,"gallery_name",$gallery,"",'All');
                    ?>  
            	<input type="submit" value="<?php echo $t->translate('btn-filter'); ?>" onclick="this.form.submit()"/>
				</form>
				<?php 
				$search_string = "final!=0";
				if(isset($gallery)&&$gallery!="") { $search_string = "gallery_id=$gallery and final!=0"; }
				$available_photos = $gallery_obj->SearchPhoto($search_string);
				
				//echo count($available_gallery);
				//die;
				if(count($available_photos)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_photos);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$photo_full = $gallery_obj->SearchPhoto("final!=0");
					print "<table class=\"datatable\" border=1 width=100%>
					<tr><td colspan='2'>";
					
                    
					foreach($photo_full as $photo) {
						$actions = '<a href="gallery/process_photo.php?action=delete&photo='.$photo->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($photo->gallery_name))."','$photo->id')\">".$t->translate('delete').'</a>';
						//print "<tr><td><img src='uploads/thumb/$photo->photo' /></td><td>$actions</td>";
					?>
                    <div style="float:left; width:160px; width:160px; border:1px solid #333333; padding:5px; text-align:center; "><img src='gallery/photo/thumb/<?=$photo->photo;?>' />
                    <p><?=$actions;?></p></div>
                    <?php
                    }
					print "</td></tr></table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
