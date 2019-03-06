<?php
	require_once('include.php');
	$profile = $_POST['Profile'];
	$tag = $_POST['Tag'];
	
	$output = array();
	exec("nohup /var/www/site/python/transcode.py ".$profile." ".$tag." > /tmp/log.txt &", $output);
	print_r($output);
	
	echo "<br>Launching Louna on profile ".$tag;
?>
