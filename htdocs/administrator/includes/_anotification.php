	<?php
	if(isset($_GET['status'])):
		?>
		<script language="JavaScript">
			$(function(){
			<?php
			switch($_GET['status'])
			{
				case 'success':
			?>
								$.prompt('Add Operation was Successful !');
			<?php
								break;
				case 'failed':
			?>
								$.prompt('Data Entry Failed!');
			<?php
								break;
				case 'invalid-data':
			?>
								$.prompt('The data seem to be malacious<br/> No Changes made to database. !');
			<?php
								break;
			case 'exists':
			?>
								$.prompt('Username already exists<br/> Please reenter Username. !');
			<?php
								break;
			case 'pass':
			?>
								$.prompt('Password Mismatched<br/> Please reenter Password. !');
			<?php
								break;
								
			}
			?>
			
			
			});
			
		</script>
		<?php
		endif;
		?>