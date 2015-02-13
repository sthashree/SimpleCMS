<script language="JavaScript">
<!--
var rows = document.getElementsByTagName('tr');
if(rows.length > 0)
{
	for (var i = 0; i < rows.length; i++) {
		rows[i].onmouseover = function() {
		this.className += ' hilite';
		}
		
		rows[i].onmouseout = function() {
		this.className = this.className.replace('hilite', '');
		}
	}
}
	function confirmDelete(name,id)
	{
		if(confirm("Are you sure you want to delete [ " + name + " ] #"+id+" ?"))
		{
			return true;
		}
		return false;
	}
	<?php
	if(isset($_GET['status'])):
		?>
	$(function(){
			<?php
			switch($_GET['status'])
			{
				case 'u-failed':
			?>
								$.prompt('No changes have been made !');
			<?php
								break;
				case 'u-success':
			?>
								$.prompt('Successfully Updated data !');
			<?php
								break;
				case 'd-success':
			?>
								$.prompt('Successfully Deleted data !');
			<?php
								break;
				case 'd-failed':
			?>
								$.prompt('Delete Data Failed !');
			<?php
								break;
				case 'p-success':
			?>
								$.prompt('Successfully Published data !');
			<?php
								break;
				case 'p-failed':
			?>
								$.prompt('Publish Data Failed !');
			<?php
								break;
				case 'invalid':
			?>
								$.prompt('Invalid Object to Add/Update/Delete !');
			<?php
								break;
				case 'd-failed-u':
			?>
								$.prompt('The Menu Item can\'t be deleted.<br/> It has submenus!!');
			<?
								break;				
			
			case 'exist-u':
			?>
								$.prompt('The Username is already Exists.Please use next username!!');
			<?
								break;				
			?>
				<?php
				case 'error-parent':
			?>
								$.prompt('The Menu Item can\'t be Updated.<br/> A menuitem cannot be parent of itself <br/>or child of its own child!!');
			<?
								break;				
			}
			?>
			});
		<?php
		endif;
		?>
-->		
</script>