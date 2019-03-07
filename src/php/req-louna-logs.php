<?php
	$output = array();
	exec("tail -n 40 /var/www/site/louna.txt", $output);
	
	foreach ($output as $line)
	{
		echo $line.'<br>';
	}
	
?>
