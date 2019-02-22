<?php

$searchC = 1;
$found = 0;

$fh = fopen('newudp.txt', 'a');

$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$pattern = "/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?):\d{1,5}/";

while ($searchC < 12)
{
	unset($content);
	curl_setopt($ch, CURLOPT_URL, "http://www.game-monitor.com/search.php?game=quake3&num=100&pg={$searchC}/");
	
	$content = curl_exec($ch);
	
	preg_match_all($pattern, $content, $matches);
	
	for ($i = 0; $i < count($matches[0]); $i++)
	{
		$found++;
		$toWrite = "{$matches[0][$i]}\n";
		echo $toWrite;
		fwrite($fh, $toWrite);
	}
	
	echo "Moving on.\n";

	$searchC++;
}

$gtsc = 1;

while ($gtsc < 14)
{
	unset($content);
	curl_setopt($ch, CURLOPT_URL, "http://www.gametracker.com/search/q3/?searchipp=50&searchpge={$gtsc}#search");
	
	$content = curl_exec($ch);
	
	preg_match_all($pattern, $content, $matches);
	
	for ($i = 0; $i < count($matches[0]); $i++)
	{
		$found++;
		$toWrite = "{$matches[0][$i]}\n";
		echo $toWrite;
		fwrite($fh, $toWrite);
	}
	
	echo "Moving on.\n";

	$gtsc++;
}

fclose($fh);
echo "Done. Found {$found} IPs.\n";

?>