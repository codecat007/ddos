<?php
$domain = $_POST['domain'];
if(isset($domain)){
    if(empty($domain)){
        die('Cannot leave blank');
    }
    $domain = str_replace("https://", "", $_POST['domain']);
    $domain = str_replace("http://", "", $_POST['domain']);
    
    $domainEx = explode("/", $domain);
    
    $domain = $domainEx[0];
    $ip = gethostbyname($domain);
    if (!filter_var($ip, FILTER_VALIDATE_IP)){
        die('Invalid URL');
    }
    else{
        die($ip);
    }
}



?>