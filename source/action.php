<html>
	<head>
	
	</head>
	
	<body>
	<div align="center">
		<?php

			function get_steam_data()
			{
				$ID = $_POST['steamID'];
				$nickname;
				$avatar;
				$profileurl;
				$isonline;
				$ownedgamescount;
				
				
				$apiReq = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=823CDA094CB4B9F62EA4365C8F521DF6&steamids=";
				$apiGames = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=823CDA094CB4B9F62EA4365C8F521DF6&steamid=";
				
				$url = $apiReq . $ID;
				$jsoncontent = file_get_contents($url);
				$json = json_decode($jsoncontent, true);
				
				//playersummaries
				$nickname = $json['response']['players'][0]['personaname'];
				$avatar = $json['response']['players'][0]['avatarfull'];
				$profileurl = $json['response']['players'][0]['profileurl'];
				$isonline = $json['response']['players'][0]['personastate'];
				
				//games
				$url = $apiGames . $ID;
				$jsoncontent = file_get_contents($url);
				$json = json_decode($jsoncontent, true);
				
				$ownedgamescount = $json['response']['game_count'];
				
				
				if($isonline == 0){
				$isonline = "User is offline";
				}else{
				$isonline = "User is online";
				}				
				
				echo "<table border=1>";
				echo "<tr><td>$nickname</td></tr>";
				echo "<tr><td><img src='$avatar'></td></tr>";
				echo "<tr><td>Status: $isonline</td></tr>";
				echo "<tr><td>Games Owned: $ownedgamescount</td></tr>";
				echo "<tr><td><a href='$profileurl'>View Steam Profile on Steam</a>";
				echo "</table>";
				
			}
			get_steam_data();
			
		?>
		
	</div>
	</body>

</html>