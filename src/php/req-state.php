<?php
	$output = array();
	exec("ps -aux | grep transcode | grep -v grep | awk '{ print $(NF-1) }'", $output);
	
	if (count($output) == 0) {
		echo "<td class='nb'>Louna is not running :</td><td class='nb'><button id='start'>Start Louna</button></td><script>$('#start').click(function(){ $('div#state').html('<td class=\'nb\'>Louna is starting ...</td>'); var profile = $('select#profile-select option:selected').val(); var tag = $('#tag').val(); if (!tag) { tag = profile; } $.post('php/req-louna-start.php', { Profile : profile , Tag : tag } ); return false; });</script>";
	}
	else {
		echo "<td class='nb'>Louna is running with profile ".$output[0]." :</td><td class='nb'><button id='stop'>Stop Louna</button></td><script>$('#stop').click(function(){ $('div#state').html('<td class=\'nb\'>Louna is stopping ...</td>'); $.post('php/req-louna-stop.php'); return false; });</script>";
	}
?>
