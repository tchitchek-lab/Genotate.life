<?php
$TMP_DIR = $_SERVER['DOCUMENT_ROOT'] . "../tmp";

$link = $_GET['link'];

$name = basename($link);

$info = array();
exec("wget --spider $link 2>&1", $info);

$remote_size = "";
foreach ($info as $line) {
    if (substr_count($line, "SIZE")) {
        $remote_size = preg_replace('/[^0-9]+/', '', $line);
    }
}
$local_size = filesize("$TMP_DIR/$name");

$progress = ($local_size / $remote_size) * 100;

echo $progress;
