	<h2> <?php echo $t->translate('user/manage-user-type');?> </h2>	
				<div class="blockDistinct">
				<a href="user.php?extra=addusertype"><img src="images/new.png" height="40" alt="<?php echo $t->translate('user/usergroup-new');?>" title="<?php echo $t->translate('user/usergroup-new');?>"></a>
				</div>	
				<div class="block">
					
				<?php 
				$usertype = new Usertype();
				$available_usertype = $usertype->Find();
				if(count($available_usertype)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_usertype);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$usertype_full = $usertype->Find();
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('user/user-label')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($usertype_full as $type):
						$actions = '<a href="user.php?extra=editusertype&type='.$type->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="user/process_user.php?action=delete&type='.$type->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($type->type))."','$type->id')\">".$t->translate('delete').'</a>';
						print "<tr><td>".$type->type."</td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
