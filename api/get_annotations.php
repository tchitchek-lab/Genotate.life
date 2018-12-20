<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/get_sequences.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/download_all_regions.php");

$encoded_id = $_POST['encoded_id'];

$connexion = connect_database();

$request = "SELECT * FROM analysis WHERE encoded_id =\"" . $encoded_id . "\"";
$results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
$analysis_id = $row['analysis_id'];

$request = "SELECT * FROM region WHERE analysis_id =\"" . $analysis_id . "\"";
$results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
$all_region = "";
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
    $all_region .= $row ['region_id'] . ",";
}
$all_region = rtrim($all_region, ",");
$all_region = explode(',', $all_region);

list($text, $file_name) = get_all_regions($all_region, $connexion, "annotation");

$file_name = str_replace(array('"', "'", ' ', ','), '_', $file_name);

header('Content-type: text/plain', true);
header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Length: ' . strlen($text));

echo $text;

exit;
