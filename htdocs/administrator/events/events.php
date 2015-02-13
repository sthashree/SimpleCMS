			<div id="body">	
            	
			<h2> <?php echo $t->translate('event/viewevents');?> </h2>	
				<div class="blockDistinct">
				<a href="event.php?extra=add_event"><img src="images/new.png" alt="<?php echo $t->translate('event/new-event');?>" title="<?php echo $t->translate('event/new-event');?>"></a>
				</div>
				<div class="block">
					
				<?php 
				$event = new event();
				$available_events = $event->Find();
				
				//echo count($available_members);
				//die;
				if(count($available_events)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_events);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$page=1;
					$ipp=20;
					$page=$_GET['page'];
					$ipp=$_GET['ipp'];
					$limit="";
					if($page!="" && $ipp!="All") { 
						$start=($page-1)*$ipp;
						$limit=" limit ".$start." , ".$ipp;
					}
					$events_full = $event->Find("",$limit);
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('event/event-title')."</th><th>".$t->translate('event/start-date')."</th><th>".$t->translate('event/end-date')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($events_full as $event):
						$actions = '<a href="event.php?extra=edit_event&event='.$event->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="events/process_event.php?action=delete&event='.$event->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($event->firstname))."','$event->id')\">".$t->translate('delete').'</a>';
						print "<tr><td>".getLanguageSpecific($event->title,$totalLanguages[0]->abbr)."</td><td>".$event->start_time."</td><td>".$event->end_time."</td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
			</div>

		