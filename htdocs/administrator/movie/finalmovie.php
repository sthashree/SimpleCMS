<?php
	if(isset($_GET['id']) && $_GET['id']!="") { $searchString = "id = '".htmlentities($_GET['id'])."'"; }
	else $searchString = "final=0";
	
//	echo $searchString;
	$objMovie = new Movie();
	$movies = $objMovie->Search($searchString);
//var_dump($movies);
?>
<h2> <?php echo $t->translate('movie/finalise');?> </h2>	
				<div class="blockDistinct" id="data">
				<form action="movie/process_movie.php" method="post" name="add-movie-form" id="add-movie-form" enctype="multipart/form-data">
<fieldset>
	<?php
		$i=0;
	 foreach($movies as $movie)
{ 
	$i++;
?>
	<div class="photo_image">
	<?=$movie->link;?><br/>
    <input type="hidden" name="data[<?=$i;?>][link]" value="<?=$movie->link;?>" />
    <input type="hidden" name="data[<?=$i;?>][external]" value="<?=$movie->external;?>" />
	</div>
    <div class="photo_description">
        <label for="title" class="required"><?php echo $t->translate('movie/title'); ?></label>	
        <input type="text" name="data[<?=$i;?>][title]" value="<?=$movie->title;?>" /> <br />
        <label for="description" class="required"><?php echo $t->translate('desc'); ?></label>	
        <table><tr><td style="padding-left:8px"><textarea name="data[<?=$i;?>][description]" cols="35" id="description_<?=$movie->id;?>" tabindex="7" title="description_<?=$movie->id;?>"><?=$movie->description;?></textarea>
    </td></tr></table>	
            <script type="text/javascript">
                bkLib.onDomLoaded(function() {
                new nicEditor({fullPanel : true}).panelInstance('description_'+<?=$movie->id;?>);
                });
            </script>
                <label for="order" class="required"><?php echo $t->translate('order'); ?></label>	
        <input type="text" name="data[<?=$i;?>][ordering]" value="<?=$movie->ordering;?>" size="5" /> <br />    
                <label for="published" class="required"><?php echo $t->translate('label-status'); ?></label>
                <select name="data[<?=$i;?>][published]" id="published" tabindex="10">
                    <option value="1" selected="selected"><?php echo $t->translate("publish"); ?></option>
                    <option <?php if($movie->published==0) { ?> selected="selected" <?php } ?> value="0"><?php echo $t->translate("unpublish"); ?></option>
                </select>
                <input type="hidden" name="data[<?=$i;?>][id]" value="<?=$movie->id;?>"/>
   	</div>
    <div style="clear:both;">&nbsp;</div>
            <?php } ?>
</fieldset>
<input type="hidden" name="action" value="finalmovie"/><!-- -->
<input type="submit" value="<?php echo $t->translate('publish'); ?>" id="submit" tabindex="11">
<input type="reset" id="reset" value="<?php echo $t->translate('btn-reset'); ?>" tabindex="12">
				</div>
