<?php
	$output = array();
	exec("head -n -1 /var/www/site/ffmpeg.txt | tail -60 ; tail -1 /var/www/site/ffmpeg.txt | tr '\r' '\n\r' | tail -1", $output);
	
	foreach ($output as $line)
	{
		echo $line.'<br>';
	}
	
?>
