<?php
if (!empty($_POST['file_path'])) {
	$file_path = $_POST['file_path'];
	$file_name = basename($file_path);
	if(isset($_POST['file_name'])){
		$file_name = $_POST['file_name'];
	}
	if ( !file_exists($file_path) ) {
		die("File not found $path");
    }
	header('Content-type: text/plain', true);
	header('Content-Disposition: attachment; filename="'.$file_name.'"');
	header("Pragma: public");header("Cache-Control: must-revalidate, post-check=0, pre-check=0");header('Content-Length: ' . strlen($text));
    set_time_limit(0);
    $file = @fopen($file_path,"rb");
    while(!feof($file))
    {
    	print(@fread($file, 1024*8));
    	ob_flush();
    	flush();
    }
    fclose($file_handle);
	exit;
}else{
	echo "ERROR: no file informations sets";
}

?>