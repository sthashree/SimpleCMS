<h2> <?php echo $t->translate('movie/view');?> </h2>	
				<div class="blockDistinct">
				<a href="movie.php?extra=movie"><img src="images/new.png" alt="<?php echo $t->translate('movie/movie-new-name');?>" title="<?php echo $t->translate('movie/movie-new-name');?>"></a>
				</div>
				<div class="block">
					
				<?php 
				$objMovie = new Movie();
				$available_movies = $objMovie->Find("","","","ordering","asc");
				//var_dump($available_movies);
				//echo count($available_movies);
				//die;
				if(count($available_movies)>0):
					$limit="";
					  $page=1;
					  $ipp=20;
					$pages = new Paginator(20);  
					$pages->items_total = count($available_movies);  
					$pages->mid_range = 9;  
					$pages->paginate();
					
				  	if(isset($_GET['page'])) $page=$_GET['page'];
				  	if(isset($_GET['ipp'])) $ipp=$_GET['ipp'];
				  	$last = ($page-1)*$ipp;
					if($ipp!="All" && isset($page)) { $limit=" limit ".$last.",".$ipp; }
  					$movies_full = $objMovie->Find("",$limit,'',"ordering","asc");
					//$movies_full = $objMovie->Find();
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('movie/movie-label')."</th><th>".$t->translate('label-order')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($movies_full as $movie):
						$actions = '<a href="movie.php?extra=finalmovie&id='.$movie->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="movie/process_movie.php?action=delete&movie='.$movie->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($movie->title))."','$movie->id')\">".$t->translate('delete').'</a>';
						print "<tr><td width='70%'>".$movie->title."</td><td>".$movie->ordering."</td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>