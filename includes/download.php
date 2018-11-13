<?php
//INITIALIZE FUNCTIONS

include ("./connect.php");
include("./get_text_sequence_annotations.php");

//CHECK VARIABLES
if (!empty($_POST['all_region'])) {
    $all_region = unserialize($_POST['all_region']);
    $all_region = explode(',', $all_region);
    $text = "";
    $written_transcripts = array();
    foreach ($all_region as $region_id)
    {
        if ($region_id == "") {
        exit("error on region_id");
        }
        $connexion = connectdatabase();
        $request = "SELECT dataset.dataset_id, dataset.name AS dataset_name, temp_region_id, temp_transcript_id, transcript.name AS transcript_name FROM region, transcript, dataset WHERE region.transcript_id=transcript.transcript_id AND region.dataset_id=dataset.dataset_id";
        $request .=	" AND region_id =\"" . $region_id . "\"";
        $results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>".mysqli_error($connexion));
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
        $dataset_id = $row['dataset_id'];
        $dataset_name = $row['dataset_name'];
        $temp_region_id = $row['temp_region_id'];
        $temp_transcript_id = $row['temp_transcript_id'];
        $transcript_name = $row['transcript_name'];
        if (!empty($_GET['type'])) {
            if ($_GET['type'] == "annotation") {
                $text .= get_annotation($dataset_id, $transcript_name, $region_id,$connexion);
                $file_name = "annotations.txt";
            }
            if ($_GET['type'] == "protein") {
                $text .= get_protein(1, $dataset_id, $transcript_name, $temp_region_id);
                $file_name = "proteins.fasta";
            }
            if ($_GET['type'] == "region") {
                $text .= get_region(1, $dataset_id, $transcript_name, $temp_region_id);
                $file_name = "regions.fasta";
            }
            if ($_GET['type'] == "transcript") {
            	//if transcript not in array written transcript
                $tmp_name = $dataset_id." ".$transcript_name." ".$temp_transcript_id;
	            if(! in_array($tmp_name, $written_transcripts)){
	                $text .= get_transcript(1, $dataset_id, $transcript_name, $temp_transcript_id);
	                $file_name = "transcripts.fasta";
	                array_push($written_transcripts, $tmp_name);
            	}
            }
        } else {
            exit ("error in download.php: type not set");
        }
    }
} else if (!empty($_GET['type'])) {
        $dataset_id = $_POST['dataset_id'];
        $dataset_name = $_POST['dataset_name'];
        $transcript_name = $_POST['transcript_name'];
        if ($_GET['type'] == "annotation") {
			$region_id = $_POST['region_id'];
            $connexion = connectdatabase();
            $text = get_annotation($dataset_id, $transcript_name, $region_id,$connexion);
            $file_name = "annotation_{$dataset_name}_{$region_id}.txt";
        }
        if ($_GET['type'] == "protein") {
			$temp_region_id = $_POST['temp_region_id'];
            $text = get_protein(1, $dataset_id, $transcript_name, $temp_region_id);
            $file_name = "protein_{$dataset_name}_{$temp_region_id}.fasta";
        }
        if ($_GET['type'] == "region") {
			$temp_region_id = $_POST['temp_region_id'];
            $text = get_region(1, $dataset_id, $transcript_name, $temp_region_id);
            $file_name = "region_{$dataset_name}_{$temp_region_id}.fasta";
        }
        if ($_GET['type'] == "transcript") {
			$temp_transcript_id = $_POST['temp_transcript_id'];
            $text = get_transcript(1, $dataset_id, $transcript_name, $temp_transcript_id);
            $file_name = "transcript_{$dataset_name}_{$temp_transcript_id}.fasta";
        }
} else {
        exit ("error in download.php");
}

$file_name = str_replace(array('"', "'", ' ', ','), '_', $file_name);

header('Content-type: text/plain', true);
header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
header("Pragma: public");header("Cache-Control: must-revalidate, post-check=0, pre-check=0");header('Content-Length: ' . strlen($text));
echo $text;
exit;

?>
