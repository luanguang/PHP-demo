<?php

function searchPort($ip, $startPort = 1, $endPort = 65535) {
    for ($i = $startPort; $i <= $endPort; $i++) {
        $fp = @fsockopen($ip, $i, $errno, $errstr, 30);
        if (!$fp) {
            echo "$errstr ($errno)\n";
        } else {
            $out = "Host: $ip\r\n";
            $out .= "port: $i\r\n";
            fwrite($fp, '');
            while (!feof($fp)) {
                echo fgets($fp, 128);
            }
            echo $out;
            fclose($fp);
        }
    }
}

