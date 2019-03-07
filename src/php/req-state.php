<?php
	$output = array();
	exec("ps -aux | grep transcode | grep -v grep | awk '{ for(i=NF-1;i<=NF-1;++i) print($i) }'", $output);
	
	if (count($output) == 0) {
		echo "<button id='start'>Start Louna</button><script>$('#start').click(function(){ $('div#state').html('Louna is starting ...'); var profile = $('select#profile-select option:selected').val(); var tag = $('#tag').val(); if (!tag) { tag = profile; } $.post('php/req-louna-start.php', { Profile : profile , Tag : tag } ); return false; });</script>";
	}
	else {
		echo "<br>Louna running with profile ".$output[0];
	}
?>
