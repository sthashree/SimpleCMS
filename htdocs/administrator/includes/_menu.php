	<!-- main menu -->
		<div id="bar">
			
<ul class="cssMenu cssMenum">
	<li class="cssMenui"><a href="index.php" class="cssMenui"><?php echo $t->translate("home"); ?></a></li>

<li class="cssMenui"><a href="#" class="cssMenui">
	<span>
	<?php echo $t->translate('user'); ?>
	</span>
	<![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul class="cssMenum">
    <li><a href="user.php?extra=user"><?php echo $t->translate('user/manage-user');?></a></li>
	<li><a href="user.php?extra=usertype"><?php echo $t->translate('user/manage-user-type');?></a></li>
	</ul>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	
</li>    
<li class="cssMenui"><a href="#" class="cssMenui">
	<span>
	<?php echo $t->translate('menu'); ?>
	</span>
	<![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul class="cssMenum">
	<li><a href="menus.php"><?php echo $t->translate('menu/menu-view-name');?></a></li>
	<li><a href="#">----------------------</a></li>
	<?php 
	$available_menu = $m->Find();
	if(is_array($available_menu))
	{
		foreach($available_menu as $menu)
		{
			print '<li><a href="menu-items.php?menu='.$menu->id.'">'.$menu->menu_name.'[<b>'.$menu->abbr.'</b>]</a></li>';
		}
	}
	 ?>
	</ul>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	
</li>
<li class="cssMenui"><a href="#" class="cssMenui">
	<span>
	<?php echo $t->translate('content'); ?>
	</span>
	<![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul class="cssMenum">
    <li><a href="languages.php"><?php echo $t->translate('language/language-man-name');?></a></li>
	<li><a href="categories.php"><?php echo $t->translate('category');?></a></li>
	<li><a href="contentman.php"><?php echo $t->translate('content/content-articleman-name');?></a></li>
	</ul>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	
</li>
	<li class="cssMenui"><a href="#" class="cssMenui"><span><?php echo $t->translate("component"); ?></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
    	<ul>
        	
            <li> <a href="gallery.php?extra=configure" class="cssMenui"><span><?php echo $t->translate("mygallery"); ?></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
          		<ul>
                    <li> <a href="gallery.php?extra=viewgallery" class="cssMenui"><?php echo $t->translate("mygallery/viewgallery"); ?> </a></li>
                    <li> <a href="gallery.php?extra=viewphoto" class="cssMenui"><?php echo $t->translate("mygallery/viewphoto"); ?> </a></li>
                </ul> 
                <!--[if lte IE 6]></td></tr></table></a><![endif]--> 
            </li>
			<li> <a href="product.php?extra=configure" class="cssMenui"><span><?php echo $t->translate("myproduct"); ?></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
          		<ul>
                    <li> <a href="product.php?extra=viewcategory" class="cssMenui"><?php echo $t->translate("myproduct/viewcategory"); ?> </a></li>
                    <li> <a href="product.php?extra=viewproduct" class="cssMenui"><?php echo $t->translate("myproduct/viewproduct"); ?> </a></li>
                </ul>  
                <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
             <li> <a href="movie.php?extra=viewmovie" class="cssMenui"><?php echo $t->translate("movie"); ?></a></li>
             <li> <a href="chirasi.php?extra=chirasi" class="cssMenui"><?php echo $t->translate("chirasi"); ?></a></li>
             <li> <a href="event.php?extra=events" class="cssMenui"><?php echo $t->translate("event"); ?></a></li>
             <li> <a href="banner.php?extra=banners" class="cssMenui"><?php echo $t->translate("banner"); ?></a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
    </li>
    
        	<li class="cssMenui"> <a href="blog.php?extra=blog" class="cssMenui"><?php echo $t->translate("myblog"); ?></a>  </li>
    
<li class="cssMenui"><a href="process_login.php?action=logout" class="cssMenui"><?php echo $t->translate("logout"); ?></a></li>
</ul>
			</div>
			
<!-- main menu end -->