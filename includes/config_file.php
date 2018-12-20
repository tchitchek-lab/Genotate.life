<?php

function read_configfile(){

    $file_path = "/var/www/genotate.life/web/genotateweb.config.php";

    if (!file_exists($file_path)) {
        echo("Config file genotateweb.config not found. $file_path");
    }
    $paths = array();
    if (file_exists($file_path)) {
        $configfile = fopen($file_path, "r");
        while (!feof($configfile)) {
            $line = fgets($configfile);
            $line = rtrim($line);
            if ($line != "" && $line != "<?php" && $line != "?>") {
                $splitline = explode(':', $line);
                $paths[$splitline[0]] = $splitline[1];
            }
        }
    }

    return $paths;
}