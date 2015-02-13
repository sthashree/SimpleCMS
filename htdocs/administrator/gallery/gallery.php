<?php
 
	include_once(ADMINPATH.'helpers/class.gallery.php');
	include_once(ADMINPATH.'helpers/paginator.class.php');
	$where =" t.published = '1'";
	if(isset($gal)) $where .=" and t.galleryname_alias = '$gal'"; 
	$gals = $objGallery->Search($where);
	
	
   
   
   $where = '';
   				
          		foreach($gals as $gal) {
					$gallery = $gal->id;
   				$search_string = "final!=0";
				if(isset($gallery)&&$gallery!="") { $search_string = "gallery_id=$gallery and final!=0"; }
				$available_photos = $objGallery->FindPhoto($gallery,'', 'all','t.id','desc',$lang);
				$totalPhotos+=count($available_photos);
				}
   ?>
	<script type="text/javascript" src="<?=BASEURL;?>/fancybox/jquery.fancybox-1.3.1.js"></script>
    
	<link rel="stylesheet" type="text/css" href="<?=BASEURL;?>/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
    <script type="text/javascript">
		$(document).ready(function() {			
			$("a[rel=group]").fancybox({
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
				'titlePosition' 	: 'inside',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : 'cxzczx') + '</span>';
				}
			});
		});
	</script>
  <style type="text/css">
  	.spot_desc div.image {
		float:left;
		margin:4px;
		height:118px;
		overflow:hidden;
	}
	.spot_desc div.image img {
		width:114px;
		-moz-border-radius:5px 5px 5px 5px;
		background:none repeat scroll 0 0 #ccc;
		padding:7px;
	}
	.spot_desc div.gallery-pane {
		width:100%;
		overflow:auto;
		background:#f0f0f0;
	
		
		
	} 
	.spot_desc div.gallery-pane div.jspHorizontalBar {
		display:block;
	}
	
	.gallerytitle {
		padding:5px 10px;
		line-height:25px;
	}
  </style>
   <div class="spot">
        <div class="spot_title">
            <div class="breadcumb"><a href="<?=BASEURL;?>/gallery-gallery.htm"><?=$t->translate("Front/gallery");?></a><?php if(isset($gallery) && $gallery!="") { ?> > <a href="<?=BASEURL.$gal->galleryname_alias;?>/gallery-gallery.htm"><?php echo $gal->gallery_name;?></a> <?php } ?></div>
        </div>
        <div class="spot_desc">
        	
          <?php 
           if($totalPhotos>0) 
		  {
            ?>
            <div>
            <?php	
			$config = $objGallery->getConfigure();
				$pages = new Paginator($config[0]->value);  
                $pages->items_total = $totalPhotos;  
                $pages->mid_range = 12;  
                $pages->paginate(0,$t->translate("previous"),$t->translate("next"));
          		foreach($gals as $gal) {
  					$gallery = $gal->id;
	      
                	$photo_full = $objGallery->FindPhoto($gallery,$pages->limit, 'all','t.id','desc',$lang);
                foreach($photo_full as $photo) {
                    ?>
                    <div class="image">
                        <a href="<?=ADMINURL;?>/gallery/photo/resized/<?=$photo->photo;?>" rel="group"><img src="<?=ADMINURL;?>gallery/photo/thumb/<?=$photo->photo;?>"></a>
                        <p><?=$photo->photo_description;?> </p>
                    </div>
                <?php } 
				}
                ?>       
            </div>
                <div style="clear:both; height:1px">&nbsp;</div>
                <div class="paginator">
                    <?php
                        echo $pages->display_pages();
                    ?>
                </div>
               <?php } 
			   else {
				?>
                <?=$t->translate("mygallery/NoImage");?>
                <?php    
			   }?>
            </div>
     	</div>