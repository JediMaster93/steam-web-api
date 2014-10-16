<html>
	<head>
	
	</head>
	
	<body>
	<div align="center">
		<?php
			$API_KEY = "823CDA094CB4B9F62EA4365C8F521DF6";

			function get_steam_data()
			{
				//apparently this thing makse file_get_contents requests faster.
				//http://stackoverflow.com/questions/3629504/php-file-get-contents-very-slow-when-using-full-url
				$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));

				$ID = userNameToSteamId($_POST['steamID']);
				if($ID == -1)
				{
					echo "FAIL";
					return -1;
				}
				
				//lets get steam id from username user inputed
				
				
				$apiKey = $GLOBALS["API_KEY"];
				$nickname;
				$avatar;
				$profileurl;
				$isonline;
				$ownedgamescount;
				
				
				//$apiReq = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=823CDA094CB4B9F62EA4365C8F521DF6&steamids=";
				//$apiGames = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=823CDA094CB4B9F62EA4365C8F521DF6&steamid=";
				$apiReq = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$apiKey&steamids=";
				$apiGames = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=$apiKey&steamid=";


				$url = $apiReq . $ID;
				$jsoncontent = file_get_contents($url, false, $context);
				$json = json_decode($jsoncontent, true);
				
				//playersummaries
				$nickname = $json['response']['players'][0]['personaname'];
				$avatar = $json['response']['players'][0]['avatarfull'];
				$profileurl = $json['response']['players'][0]['profileurl'];
				$isonline = $json['response']['players'][0]['personastate'];
				
				//games
				$url = $apiGames . $ID;
				$jsoncontent = file_get_contents($url, false, $context);
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
			function userNameToSteamId($UserName)
			{
				$apiKey = $GLOBALS['API_KEY'];
				$apiUrl ="http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=$apiKey&vanityurl=$UserName";
				
				$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
				//file_get_contents("http://www.something.com/somepage.html",false,$context);

				
				$jsonContent = file_get_contents($apiUrl, false, $context);
				$json = json_decode($jsonContent, true);
				$json = $json['response'];
				
				if($json['success'] == 1)
				{
					return $json['steamid'];
				}
				return -1;

			}
			get_steam_data();
			
		?>
		
	</div>
	</body>

</html>