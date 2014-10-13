<html>
	<head>
	
	</head>
	
	<body>
		<?php
				function get_steam_data($userName)
				{
					$apiReq = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=823CDA094CB4B9F62EA4365C8F521DF6&steamids=";
					echo $apiReq.$userName;
					$req = file_get_contents($apiReq . $userName);
					echo var_dump($req);
				}
				
				echo var_dump($_POST);
				get_steam_data($_POST["steamID"])
				
				
			


		?>
		
	
	</body>

</html>