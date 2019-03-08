<?php
	$output = array();
	exec("cat /var/www/site/ffmpeg.txt | tr '\r' '\n\r' | awk 'BEGIN { frame=\"\" } { if($1 ~ /frame/) frame=$0; else { if(frame != \"\") { print frame; print $0 } else print $0 } } END { if(frame != \"\") print frame; }'", $output);
	foreach ($output as $line) { echo $line.'<br>';	}
?>
