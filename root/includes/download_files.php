<?php
set_time_limit(0);

if (!empty($_POST['analysis_id']) && !empty($_POST['type'])) {

    if ($_POST['type'] == "annotation") {
        $file_base = $_SERVER['DOCUMENT_ROOT'] . "../workspace/storage/";
    } else if ($_POST['type'] == "reference") {
        $file_base = $_SERVER['DOCUMENT_ROOT'] . "../workspace/blastdb/";
    } else {
        die("Unknow file type");
    }

    $file_path = $file_base . $_POST['analysis_id'];

    if (!file_exists($file_path)) {
        die("File not found " . $file_path);
    }

    $file_name = basename($file_path);
    if (isset($_POST['file_name'])) {
        $file_name = $_POST['file_name'];
    }

    header('Content-type: text/plain', true);
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header("Pragma: public");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    $file = @fopen($file_path, "rb");
    while (!feof($file)) {
        print(@fread($file, 1024 * 8));
        ob_flush();
        flush();
    }
    fclose($file);

    exit;
}
