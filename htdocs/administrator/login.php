<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simple CMS</title>
<link rel="stylesheet" type="text/css" href="css/admin_style.css" />
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/login.helper.js" type="text/javascript"></script>
</head>
<body bgcolor="white">
  
  

   <div id="login">
      <img alt="Who wants simplecms?" src="images/simplecms.gif" />
     <form id="UserLoginForm" method="post" action="process_login.php">
     	<strong>
	 	<?php
		if(isset($_GET['status']))
		{
			switch($_GET['status'])
			{
				case 'empty-fields':
						echo '<span style="background-color:red; font-size:10px"><font color="white">The Username and Password Field(s) cannot be empty !</font></span>';
						break;
				case 'failed':
						echo '<span style="background-color:red; font-size:10px"><font color="white">Login Failed !, It seems that you are not Authentic.</font></span>';
						break;
				case 'logged-out':
						echo '<span style="background-color:green; font-size:10px"><font color="white">Successfully logged out of the system. Thank you for Using.</font></span>';
						break;
			}
		}
		?>		
		</strong>
       <div class="input text"><label for="UserUsername">Username</label>

       <input name="data[User][username]" type="text" value="" id="UserUsername" />
      </div>
      <div class="input password">
       <label for="UserPassword">Password</label>
       <input type="password" name="data[User][password]" value="" id="password" />
     </div>
       <div class="submit"><input type="submit" value="Let me in" />
       </div>
	  <input type="hidden" name="action" value="login" />
     </form> 
 </div>
    

</body>
</html>