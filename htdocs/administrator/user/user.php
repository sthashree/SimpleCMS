
                <h2> <?php echo $t->translate('user/manage-user');?> </h2>	
				<div class="blockDistinct">
				<a href="user.php?extra=adduser"><img src="images/new.png" height="40" alt="<?php echo $t->translate('user/user-new');?>" title="<?php echo $t->translate('user/user-new');?>"></a>
				</div>
				
				<div class="block">
					
				<?php 
				$users = new Users();
				$available_user = $users->Find();
				//var_dump($available_user);
				if(count($available_user)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_usertype);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$usertype_full = $users->Find();
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('user/label-name')."</th><th>".$t->translate('user/label-username')."</th><th>".$t->translate('user/user-role')."</th><th>".$t->translate('user/user-active')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($usertype_full as $type):
						$actions = '<a href="user.php?extra=edituser&id='.$type->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="user/process_user.php?action=delete&member='.$type->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($type->type))."','$type->id')\">".$t->translate('delete').'</a>';
						$active = "user_inactive.png";
						if($type->active =="1") {
						$active = "user_active.png";
						}
						print "<tr><td>".$type->firstname." ".$type->middlename." ".$type->lastname."</td><td>".$type->username."</td><td>".$type->type."</td><td><a <a href='user/process_user.php?action=active&state=".$type->active."&member=".$type->id."'><img src ='icons/".$active."' alt ='".$type->firstname."' width ='20'  /></a></td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
