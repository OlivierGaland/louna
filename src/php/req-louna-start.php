<?php
	require_once('include.php');
	$profile = $_POST['Profile'];
	$tag = $_POST['Tag'];
	
//	$output = array();
//	exec("nohup python3 -u /var/www/site/python/transcode.py ".$profile." ".$tag." > /var/www/site/log.txt 2>&1&", $output);
//	print_r($output);
	exec("nohup python3 -u /var/www/site/python/transcode.py ".$profile." ".$tag." > /var/www/site/louna.txt 2>&1&");
	
	echo "<br>Launching Louna on profile ".$tag;
?>
