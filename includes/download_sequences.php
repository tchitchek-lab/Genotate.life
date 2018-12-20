<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/get_sequences.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/download_all_regions.php");

$connexion = connect_database();

if (!empty($_POST['all_region'])) {

    $all_region = unserialize($_POST['all_region']);
    $all_region = explode(',', $all_region);
    $type = $_GET['type'];

    list($text, $file_name) = get_all_regions($all_region, $connexion, $type);
}

if (!empty($_GET['type']) && empty($_POST['all_region'])) {
    $analysis_id = $_POST['analysis_id'];
    $dataset_name = $_POST['dataset_name'];
    $transcript_name = $_POST['transcript_name'];

    if ($_GET['type'] == "annotation") {
        $region_id = $_POST['region_id'];
        $connexion = connect_database();
        $text .= get_annotations($analysis_id, $transcript_name, $region_id, $connexion);
        $file_name = "annotation_{$dataset_name}_{$region_id}.txt";
    }

    if ($_GET['type'] == "protein") {
        $relative_region_id = $_POST['relative_region_id'];
        $text .= get_proteins(1, $analysis_id, $transcript_name, $relative_region_id);
        $file_name = "protein_{$dataset_name}_{$relative_region_id}.fasta";
    }

    if ($_GET['type'] == "region") {
        $relative_region_id = $_POST['relative_region_id'];
        $text .= get_regions(1, $analysis_id, $transcript_name, $relative_region_id);
        $file_name = "region_{$dataset_name}_{$relative_region_id}.fasta";
    }

    if ($_GET['type'] == "transcript") {
        $relative_transcript_id = $_POST['relative_transcript_id'];
        $text .= get_transcripts(1, $analysis_id, $transcript_name, $relative_transcript_id);
        $file_name = "transcript_{$dataset_name}_{$relative_transcript_id}.fasta";
    }
}


$file_name = str_replace(array('"', "'", ' ', ','), '_', $file_name);

header('Content-type: text/plain', true);
header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Length: ' . strlen($text));

echo $text;

exit;
