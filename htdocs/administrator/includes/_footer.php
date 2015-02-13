<div id="footer" title="Yuwazu">
				<p>
					<?php
					$time_end = microtime(true);
					$time = $time_end - $time_start;
					$time = $time * 100;
					echo "Page Rendered in $time ms\n";
					?><br/>
				 &copy; <a href="#" target="_blank">　ユアーズグループ.</a> <!--<a href="http://sujandhakal.com.np/" target="_blank">Sujan Dhakal</a>-->  | <a href="?lang=jp<?php echo $queryString;?>">日本語</a> | <a href="?lang=en<?php echo $queryString;?>">English</a> 
				</p>
</div>