<?php
	require_once('include.php');
	$profile = $_POST['Profile'];
	$tag = $_POST['Tag'];
	exec("nohup python3 -u /var/www/html/python/transcode.py ".$profile." ".$tag." > /var/www/html/louna.txt 2>&1&");
?>
