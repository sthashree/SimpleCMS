<?php
    if( (  function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()  )
             || 
		(  ini_get('magic_quotes_sybase') && ( strtolower(ini_get('magic_quotes_sybase')) != "off" )  )
      )
   {
		 foreach($data as $k => $v) $data[$k] = stripslashes($v);
   }
?>