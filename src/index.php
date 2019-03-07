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
	
		<div id='louna-logs'></div>
		<br><br>
		<div id='ffmpeg-logs'></div>

	</body>
	
	<script>
		function myTimer() {
			$("div#louna-logs").load("php/req-louna-logs.php");
			$("div#ffmpeg-logs").load("php/req-ffmpeg-logs.php");
		}
		var myTimerId = null;
		myTimerId = setInterval(myTimer, 10000);
		$("div#profile").load("php/req-profile.php");
		$("div#state").html("<button id='start'>Start Louna</button>"); //TODO replace with a req getting daemon current status
		$('#start').click(function(){
							$("div#state").html("Louna is starting ...");
							var profile = $("select#profile-select option:selected").val();
							var tag = $("#tag").val();
							if (!tag) { tag = profile; }
							//$.post('php/req-louna-start.php', { Profile : profile , Tag : tag } , function(ret) { $("div#state").html(ret); if (myTimerId !== null) { myTimerId = setInterval(myTimer, 10000); /* background timestamp check every 10 sec */ } } );							
							$.post('php/req-louna-start.php', { Profile : profile , Tag : tag } , function(ret) { $("div#state").html(ret); } );							
							return false; // stops browser from doing default submit process
						});		
	</script>
	
</html>
