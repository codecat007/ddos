<?php

include("header.php");
?>
	<div class="box">
		<h2>Games</h2>
		<div class="box-content">
		<link href="styles.css" rel="stylesheet" type="text/css">
	</head>	
	<body>
		<p>
			<center>
				
				<?php
					$work = $_GET['game'];
					if ($work == "")
					{
						// We are on the main page.
						?>
						<p><a href="games.php?game=game1">Sushi Go Round</a></p>
                        <p><a href="games.php?game=game2">Sushi Go Round</a></p>
                        <p><a href="games.php?game=game3">Sushi Go Round</a></p>
                        <p><a href="games.php?game=game4">Sushi Go Round</a></p>
                        <p><a href="games.php?game=game5">Sushi Go Round</a></p>
						<?php
					}elseif($work == "game1"){
						// Show the game.
						?>
							<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="480" id="sushigoround" align="middle"><param name="allowScriptAccess" value="sameDomain" /><param name="menu" value="false" /><param name="allowFullScreen" value="false" /><param name="movie" value="http://www.miniclip.com/swfcontent/freegames/sushigoround.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="http://www.miniclip.com/swfcontent/freegames/sushigoround.swf" quality="high" bgcolor="#ffffff" width="640" height="480" name="sushigoround" menu="false" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>						<?php
					}elseif($work == "game2"){
						// Show the game.
						?>
                            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="480" id="sushigoround" align="middle"><param name="allowScriptAccess" value="sameDomain" /><param name="menu" value="false" /><param name="allowFullScreen" value="false" /><param name="movie" value="<iframe src="http://www.miniclip.com/games/fragger-bonus-blast/en/webgame.php" frameborder="0" style="border:none;" width="800" height="600" scrolling="no"></iframe>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="http://www.miniclip.com/swfcontent/freegames/sushigoround.swf" quality="high" bgcolor="#ffffff" width="640" height="480" name="sushigoround" menu="false" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>
                        <?php
					}elseif($work == "game3"){
						// Show the game.
						?>
                            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="480" id="sushigoround" align="middle"><param name="allowScriptAccess" value="sameDomain" /><param name="menu" value="false" /><param name="allowFullScreen" value="false" /><param name="movie" value="http://www.miniclip.com/swfcontent/freegames/sushigoround.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="http://www.miniclip.com/swfcontent/freegames/sushigoround.swf" quality="high" bgcolor="#ffffff" width="640" height="480" name="sushigoround" menu="false" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>
                        <?php
					}elseif($work == "game4"){
						// Show the game.
						?>
                            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="480" id="sushigoround" align="middle"><param name="allowScriptAccess" value="sameDomain" /><param name="menu" value="false" /><param name="allowFullScreen" value="false" /><param name="movie" value="http://www.miniclip.com/swfcontent/freegames/sushigoround.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="http://www.miniclip.com/swfcontent/freegames/sushigoround.swf" quality="high" bgcolor="#ffffff" width="640" height="480" name="sushigoround" menu="false" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>
                        <?php
					}elseif($work == "game5"){
						// Show the game.
						?>
                            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="480" id="sushigoround" align="middle"><param name="allowScriptAccess" value="sameDomain" /><param name="menu" value="false" /><param name="allowFullScreen" value="false" /><param name="movie" value="http://www.miniclip.com/swfcontent/freegames/sushigoround.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="http://www.miniclip.com/swfcontent/freegames/sushigoround.swf" quality="high" bgcolor="#ffffff" width="640" height="480" name="sushigoround" menu="false" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>
                              
                        <?php
					}
				
				?>
			
			</center>
		</p>
		
		</div>
    </div>
	
	</body>
	
	<?php
	
include("footer.php");

?>