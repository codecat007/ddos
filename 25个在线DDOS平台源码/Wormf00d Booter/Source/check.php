<?php

include("header.php");
?>
	<div class="box">
		<h2>Website Online Checker</h2>
		<div class="box-content">
		<link href="styles.css" rel="stylesheet" type="text/css">
		<script>
			function clearDomainInput(e) {
			  if (e.cleared) { return; }
			  e.cleared = true;
			  e.value = '';
			  e.style.color = '#000';
			}
		</script>
	</head>	
	<body>
		<p><center><?php if (isset($_GET['url'])==false){ ?>
			
				<form method="get" action="check.php" name="downform" onsubmit="return formSubmit()"> 
				  Is
				  <input type="text" name="url" id="domain_input" value="domain.com" onclick="clearDomainInput(this);" /> 
				  down for everyone
				  <a href="#" onclick="formSubmit();">or just me?</a> 
				  <input type="submit" style="display: none;" /> 
				</form> 
			
			<?php }else{
			
			$url = $_GET['url'];
			if ($fp = fopen('http://www.downforeveryoneorjustme.com/' . $url, 'r')) {
				$content = '';
				// keep reading until there's nothing left 
				while ($line = fread($fp, 1024)) {
					$content .= $line;
				}

				// do something with the content here
				if (strpos($content, "It's just you.") !== false) {
				// do not use != instead!!
				echo "<b>".$url."</b> is up. Try hitting it harder! (needs moar f00d)";
				} else {
				echo "<b>".$url."</b> is down. Good work!";
				}
			} else {
				// an error occured when trying to open the specified url 
			}
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