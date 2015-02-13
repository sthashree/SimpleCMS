<div class="galleryCategory">       	<h3 class="widget-title"><?=$t->translate("Front/gallery");?></h3>						
      	                  <ul>
                          	
                <?php 
					
					$gal = $_GET['item'];
					include_once(ADMINPATH.'helpers/class.gallery.php');
					$objGallery = new Gallery();
					$galleries = $objGallery->Find();
					$class="first";
					$i=0;
					foreach($galleries as $gallery) { 
					//echo $gallery->id;
					$photos = $objGallery->FindPhoto($gallery->id);
					
		if($i%2==0) { $class="first"; } else $class = "second";
					//var_dump($photos);
					$num_photos=count($photos);
				 ?>
                            <li class="<?=$class;?>"><a <?php if($gal == $gallery->galleryname_alias) { ?> class="selected" <?php } ?> href="<?=BASEURL.$gallery->galleryname_alias;?>/gallery-gallery.htm" title="<?=$gallery->gallery_name;?>"><?=$gallery->gallery_name;?></a><span class="countPhotos">(<?=$num_photos;?>)</span></li>
                    	<?php 
						$i++;
						} ?>
                          </ul>
                    	</div>