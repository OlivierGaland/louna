<?php
	$output = array();
	exec("tail -n 10 /var/www/html/louna.txt", $output);
	foreach ($output as $line) { echo $line.'<br>'; }
?>
