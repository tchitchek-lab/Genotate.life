<?php
//echo '<pre>'; print_r($argv); echo '</pre>';
$dataset_id   = $argv[1];
$dataset_name = $argv[2];

include ("connect.php");
$connexion = connectdatabase();

$transcript_id_array = array();
$region_id_array = array();

$path_dir = dirname(dirname(__DIR__)) . "/tmp/$dataset_id/";

$path = $path_dir."transcripts_info.tab";
if ( !file_exists($path) ) {
	exit("File not found: ".$path);
}
$file_handle = fopen($path, "r");
$line = fgets($file_handle);
while (!feof($file_handle)) {
	$line = fgets($file_handle);
	if ($line != ""){
		$request = "INSERT INTO transcript (temp_transcript_id, name, description, size, dataset_id) VALUES (";
		$tab = explode("\t",$line);
		$request .= " '".$tab[0]."',";
		$request .= " '".$tab[1]."',";
		$request .= " '".$tab[2]."',";
		$request .= " '".$tab[3]."',";
		$request .= " '$dataset_id') ";
		echo $request."\n";
		$results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>".mysqli_error($connexion));
		$transcript_id = mysqli_insert_id($connexion);
		$transcript_id_array[$tab[0]] = $transcript_id;
	}
}
fclose($file_handle);
//echo '<pre>'; print_r($transcript_id_array); echo '</pre>';

$path = $path_dir."regions_info.tab";
if ( !file_exists($path) ) {
	exit("File not found: ".$path);
}
$file_handle = fopen($path, "r");
$line = fgets($file_handle);
while (!feof($file_handle)) {
	$line = fgets($file_handle);
	if ($line != ""){
		$request = "INSERT INTO region (temp_region_id, begin, end, size, strand, coding, type, transcript_id, dataset_id) VALUES (";
		$tab = explode("\t",$line);
		$request .= " '".$tab[0]."',";
		$request .= " '".$tab[1]."',";
		$request .= " '".$tab[2]."',";
		$request .= " '".$tab[3]."',";
		$request .= " '".$tab[4]."',";
		$request .= " '".$tab[5]."',";
		$request .= " '".$tab[6]."',";
		$request .= " '".$transcript_id_array[intval($tab[7])]."',";
		$request .= " '$dataset_id') ";
		echo $request."\n";
		$results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>".mysqli_error($connexion));
		$region_id = mysqli_insert_id($connexion);
		$region_id_array[$tab[0]] = $region_id;
	}
}
fclose($file_handle);

$path = $path_dir."all_annotations.tab";
if ( !file_exists($path) ) {
	echo("File not found: ".$path);
}else {
	$file_handle = fopen($path, "r");
	while (!feof($file_handle)) {
		$line = fgets($file_handle);
		if ($line != ""){
			$request = "INSERT INTO annotation (dataset_id, region_id, service, begin, end, name, description) VALUES (";
			$tab = explode("\t",$line);
			$request .= " '".$dataset_id."',";
			$request .= " '".$region_id_array[intval($tab[0])]."',";
			$request .= " '".$tab[1]."',";
			$request .= " '".$tab[2]."',";
			$request .= " '".$tab[3]."',";
			$request .= " '".$tab[4]."',";
			$request .= " '".$tab[5]."') ";
			echo $request."\n";
			$results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>".mysqli_error($connexion));
		}
	}
	fclose($file_handle);
}

$path_dest = dirname(dirname(__DIR__)) . "/workspace/storage/{$dataset_id}/";
rename($path_dir, $path_dest) or die("Error on move folder");

$request = "UPDATE dataset SET state='complete' WHERE dataset_id='$dataset_id'";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );


$request = "SELECT encoded_id FROM dataset WHERE dataset_id='$dataset_id'";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
$row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
$encoded_id = $row ['encoded_id'];

if(!empty($argv[3])){
	$email=$argv[3];
	$message = "Dear user,<br>\r\n
	<br>\r\n
	Thanks for using <a href='http://www.genotate.life'>Genotate</a> transcripts annotation platform.<br>\r\n
	Your database $dataset_name is now available online.<br>\r\n
  <a href='https://genotate.life/index.php?page=display&encoded_id=$encoded_id'>https://genotate.life/index.php?page=display&encoded_id=$encoded_id</a><br>\r\n
	Use the following link to search for specific annotated transcripts.<br>\r\n
  <a href='https://genotate.life/index.php?page=search_annotations&encoded_id=$encoded_id'>https://genotate.life/index.php?page=search_annotations&encoded_id=$encoded_id</a><br>\r\n
	<br>\r\n
	Best regards<br>\r\n";
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Genotate <noreply@genotate.life>' . "\r\n";
	
	mail($email, "Genotate - $dataset_name is available online", $message, $headers);
}
?>