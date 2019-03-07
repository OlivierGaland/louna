<?php
	require_once('include.php');
	$profile = $_POST['Profile'];
	$tag = $_POST['Tag'];
	exec("nohup python3 -u /var/www/site/python/transcode.py ".$profile." ".$tag." > /var/www/site/louna.txt 2>&1&");
?>
