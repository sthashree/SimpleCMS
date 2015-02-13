<?php
	$galleries = $gallery_obj->Find();
	$gallery = makeclean($_POST['gallery']);
?>
<h2> <?php echo $t->translate('chirasi-list');?> </h2>	
				<div class="block">
				<?php 
				$search_string = " final!=0 group by chirasidate desc";
				$available_photos = $gallery_obj->Search($search_string);
				
				//echo count($available_gallery);
				//die;
				if(count($available_photos)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_photos);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$photo_full = $gallery_obj->Search($search_string);
					print "<table class=\"datatable\" border=1 width=100%>";
					print"<tr><th> ".$t->translate("chirasi/chirasi-list")."</th><th>".$t->translate("action")."</th></tr><tr>";
					
					
                    
					foreach($photo_full as $photo) {
						$chirasi_full = $gallery_obj->Search("final!=0 && chirasidate = '$photo->chirasidate'");
						//var_dump($chirasi_full);
						print "<tr><td>";
						$actions = '<a href="chirasi/process_chirasi.php?action=delete&photo='.$photo->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($photo->gallery_name))."','$photo->id')\">".$t->translate('delete').'</a>';
						$actions.="<a onclick=\"previewMe('".$chirasi_full[0]->photo."','".$chirasi_full[1]->photo."')\" href=\"#\">".$t->translate('preview')."</a>";
						//print "<tr><td><img src='uploads/thumb/$photo->photo' /></td><td>$actions</td>";
					print $photo->photo_description;?>&nbsp;&nbsp;<a href="chirasi.php?extra=edit_chirasi&chirasidate=<?=$photo->chirasidate;?>"><?php print $photo->chirasidate;?></a><?="</td><td>".$actions."</td></tr>";
					}
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
                
                <script type="text/javascript">
					function previewMe(file1, file2) {
						if(file1!="")
						{
							window.open("<?=ADMINURL;?>/chirasi/uploads/"+file1,"mywindow1");	
						}
						if(file2!="")
						{
							window.open("<?=ADMINURL;?>/chirasi/uploads/"+file2,"mywindow2");	
						}
					}
				</script>
