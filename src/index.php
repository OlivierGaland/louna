<html>
	<head>
		<title>Louna beta 0.1</title>
	</head>
	
	<script src="javascript/jquery-3.2.1.min.js"></script>
	
	<body>
	
		<table>
			<tr>
				<td>

	<?php
		require_once('php/include.php');
		
		echo "<table>";
		echo "<tr><th colspan='2'>Louna transcoder daemon</th></tr>";
		echo "<tr><td>Watch dir :</td><td>".Ctx::Get()->settings->input_dir."</td></tr>";
		echo "<tr><td>Files to process :</td><td>".(Ctx::Get()->settings->input_type_list == "" ? "" : "*.".str_replace(" ",", *.",Ctx::Get()->settings->input_type_list))."</td></tr>";
		echo "<tr><td>Transcoder profile :</td><td><div id='profile'></div></td></tr>";
		echo "<tr><td>Tag for transcoded files :</td><td><input type='text' id='tag' value=''></input></td></tr>";
		echo "<tr><td colspan='2'><div id='state'></div></td></tr>";
		echo "</table>";
		
		
	?>
	
				</td>
				<td>
					<img src="pic/louna.png" alt="Louna (2009-2018)">
				</td>
			</tr>
		</table>
	
		<table><tr><td><div id='louna-logs'></div></td></tr></table>
		<table><tr><td><div id='ffmpeg-logs'></div></td></tr></table>

	</body>
	
	<script>
		function myTimer() {
			$("div#louna-logs").load("php/req-louna-logs.php");
			$("div#ffmpeg-logs").load("php/req-ffmpeg-logs.php");
			$("div#state").load("php/req-state.php");
		}
		var myTimerId = null;
		$("div#profile").load("php/req-profile.php");
		myTimer();
		myTimerId = setInterval(myTimer, 10000);
	</script>
	
</html>
