<html>
	<head>
		<meta name="robots" content="noindex">
		<link rel="stylesheet" type="text/css" href="css/theme.css">
		<title>Louna beta 0.1</title>
	</head>
	<script src="javascript/jquery-3.2.1.min.js"></script>
	<body>
		<table class="base">
			<tr>
				<td class="top">
					<table><tr class="nb"><th class="nb" colspan='2'>Louna transcoder daemon :</th></tr>
						<?php
							require_once('php/include.php');
							echo "<tr class='nb'><td class='nb'>Watch dir :</td><td class='nb'>".Ctx::Get()->settings->input_dir."</td></tr>";
							echo "<tr class='nb'><td class='nb'>Files to process :</td><td class='nb'>".(Ctx::Get()->settings->input_type_list == "" ? "" : "*.".str_replace(" ",", *.",Ctx::Get()->settings->input_type_list))."</td></tr>";
						?>
						<tr class="nb"><td class="nb">Transcoder profile :</td><td class="nb"><div id='profile'></div></td></tr>
						<tr class="nb"><td class="nb">Tag for transcoded files :</td><td class="nb"><input type='text' id='tag' value=''></input></td></tr>
						<!--<tr class="nb"><td class="nb" colspan='2'><div id='state'></div></td></tr>-->
						
					</table>
					<table><tr class="nb"><div id='state'></div></tr></table>
				</td>
				<td class="pic">
					<img src="pic/louna.png" alt="Louna (2009-2018)"  title="Software named in memory of my loved cat Louna (2009-2018)">
					<a class="link" href="http://blog.hyenasoft.com" target="_blank">Homepage</a>
					<a class="link" href="https://github.com/OlivierGaland/louna" target="_blank">Github</a>
				</td>
			</tr>
		</table>

		<br>
		<table class="base">
			<tr><th>Louna Logs :</th></tr>
			<tr><td><div id='louna-logs'></div></td></tr>
		</table>
		<br>
		<table class="base">
			<tr><th>Ffmpeg Logs :</th></tr>
			<tr><td><div id='ffmpeg-logs'></div></td></tr>
		</table>
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
