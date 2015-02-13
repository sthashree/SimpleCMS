<?php 
require_once('includes/_init.php'); 
require_once('helpers/paginator.class.php');
require_once('helpers/class.member.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			ユアーズ
		</title>
        
        <link rel="shortcut icon" href="../images/favicon.ico">
		<?php require_once('includes/_meta.php'); ?>
		<?php require_once('includes/_unotification.php'); ?>	
	</head>
	<body>
		<div id="topOfPage">
			<a name="topOfPage">&nbsp;</a>
		</div>
		
		<div id="conteiner">
			
			<?php require_once('includes/_header.php'); ?>
			
			<?php require_once('includes/_menu.php'); ?>

			<div id="body">		
			<h2> <?php echo $t->translate('member/view-title');?> </h2>	
				<div class="blockDistinct">
				<a href="add_member.php"><img src="images/new.png" alt="<?php echo $t->translate('member/member-new-name');?>" title="<?php echo $t->translate('member/member-new-name');?>"></a>
				</div>
				<div class="block">
					
				<?php 
				$member = new Member();
				$available_members = $member->Find();
				//echo count($available_members);
				//die;
				if(count($available_members)>0):
					$pages = new Paginator(20);  
					$pages->items_total = count($available_members);  
					$pages->mid_range = 9;  
					$pages->paginate();
					$members_full = $member->Find();
					print "<table class=\"datatable\" border=1 width=100%>
					<thead><tr><th>".$t->translate('member/member-label')."</th><th>".$t->translate('member/member-email')."</th><th>".$t->translate('action')."</th></tr></thead>
					";
					foreach($members_full as $member):
						$actions = '<a href="edit_member.php?member='.$member->id.'">'.$t->translate('edit').'</a>&nbsp;&nbsp;<a href="process_member.php?action=delete&member='.$member->id.'" '."onclick=\"return confirmDelete('".trim(addslashes($member->firstname))."','$member->id')\">".$t->translate('delete').'</a>';
						print "<tr><td>".$member->firstname." ".$member->middlename." ".$member->lastname."</td><td>$member->email</td><td>$actions</td>";
					endforeach;
					print "</table>";
					echo $pages->display_pages();
					echo  $pages->display_items_per_page();
				endif;
				?>
				</div>
			</div>

		<?php require_once('includes/_footer.php'); ?>
		</div>
	</body>
</html>