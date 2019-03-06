<?php
	require_once('include.php');

	echo '<select id="profile-select">';
	foreach(Ctx::Get()->profiles as $key => $xml) {
		echo '<option value="'.$key.'">'.$key.' : '.$xml->description.'</option>';
	}
	echo '</select>';

?>
