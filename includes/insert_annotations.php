<?php
$_SERVER['DOCUMENT_ROOT']='/var/www/genotate.life/web';
include("/var/www/genotate.life/web/includes/connect_database.php");

function update_dataset_status($analysis_id, $connexion)
{
    $request = "UPDATE analysis SET status='complete' WHERE analysis_id='$analysis_id'";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}

function get_dataset_encodeid($analysis_id, $connexion)
{
    $request = "SELECT encoded_id FROM analysis WHERE analysis_id='$analysis_id'";
    $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
    $encoded_id = $row ['encoded_id'];
    return $encoded_id;
}

function insert_annotations($path, $analysis_id, $region_id_array, $connexion)
{
    if (!file_exists($path)) {
        echo("File not found: " . $path);
    } else {
        $file_handle = fopen($path, "r");
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            if ($line != "") {
                $request = "INSERT INTO annotation (analysis_id, region_id, algorithm, begin, end, name, description) VALUES (";
                $tab = explode("\t", $line);
                $request .= " '" . $analysis_id . "',";
                $request .= " '" . $region_id_array[intval($tab[0])] . "',";
                $request .= " '" . $tab[1] . "',";
                $request .= " '" . $tab[2] . "',";
                $request .= " '" . $tab[3] . "',";
                $request .= " '" . $tab[4] . "',";
                $request .= " '" . $tab[5] . "') ";
                $results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>" . mysqli_error($connexion));
            }
        }
        fclose($file_handle);
    }
}

function send_email($dataset_name, $encoded_id, $email)
{
    $message = "Dear user,<br>\r\n
	<br>\r\n
	Thank you for using the Genotate transcript annotation platform.<br>\r\n
	<br>\r\n
	The analysis of your dataset '" . $dataset_name . "' is now completed.<br>\r\n
	<br>\r\n
	Please use the following link to access your annotation results: <a href='https://genotate.life/index.php?page=view_annotations&encoded_id=$encoded_id'>https://genotate.life/index.php?page=view_annotations&encoded_id=$encoded_id</a>.<br>\r\n
	Please use the following link to search for specific annotated transcripts:<br>\r\n
  <a href='https://genotate.life/index.php?page=explore_annotations&encoded_id=$encoded_id'>https://genotate.life/index.php?page=explore_annotations&encoded_id=$encoded_id</a>.<br>\r\n
	<br>\r\n
	Best regards,<br>\r\n
	<br>\r\n
	The Genotate Platform";

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Genotate <noreply@genotate.life>' . "\r\n";

    mail($email, "Genotate.life - your analysis '" . $dataset_name . "' is now completed", $message, $headers);
}

function process_transcripts($path, $analysis_id, $connexion, $transcript_id_array)
{
    if (!file_exists($path)) {
        exit("File not found: " . $path);
    }
    $file_handle = fopen($path, "r");
    fgets($file_handle);
    while (!feof($file_handle)) {
        $line = fgets($file_handle);
        if ($line != "") {
            $request = "INSERT INTO transcript (relative_transcript_id, name, description, size, analysis_id) VALUES (";
            $tab = explode("\t", $line);
            $request .= " '" . $tab[0] . "',";
            $request .= " '" . $tab[1] . "',";
            $request .= " '" . $tab[2] . "',";
            $request .= " '" . $tab[3] . "',";
            $request .= " '$analysis_id') ";
            $results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>" . mysqli_error($connexion));
            $transcript_id = mysqli_insert_id($connexion);
            $transcript_id_array[$tab[0]] = $transcript_id;
        }
    }
    fclose($file_handle);
    return $transcript_id_array;
}

function process_regions($path, $transcript_id_array, $analysis_id, $connexion, $region_id_array)
{
    if (!file_exists($path)) {
        exit("File not found: " . $path);
    }
    $file_handle = fopen($path, "r");
    fgets($file_handle);
    while (!feof($file_handle)) {
        $line = fgets($file_handle);
        if ($line != "") {
            $request = "INSERT INTO region (relative_region_id, begin, end, size, strand, coding, type, transcript_id, analysis_id) VALUES (";
            $tab = explode("\t", $line);
            $request .= " '" . $tab[0] . "',";
            $request .= " '" . $tab[1] . "',";
            $request .= " '" . $tab[2] . "',";
            $request .= " '" . $tab[3] . "',";
            $request .= " '" . $tab[4] . "',";
            $request .= " '" . $tab[5] . "',";
            $request .= " '" . $tab[6] . "',";
            $request .= " '" . $transcript_id_array[intval($tab[7])] . "',";
            $request .= " '$analysis_id') ";
            $results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>" . mysqli_error($connexion));
            $region_id = mysqli_insert_id($connexion);
            $region_id_array[$tab[0]] = $region_id;
        }
    }
    fclose($file_handle);
    return $region_id_array;
}

$connexion = connect_database();

$analysis_id = $argv[1];
$dataset_name = $argv[2];

$transcript_id_array = array();
$region_id_array = array();

$path_dir = "/var/www/genotate.life/web/" . "../tmp/$analysis_id/";

$path = $path_dir . "transcripts_info.tab";
$transcript_id_array = process_transcripts($path, $analysis_id, $connexion, $transcript_id_array);

$path = $path_dir . "regions_info.tab";
$region_id_array = process_regions($path, $transcript_id_array, $analysis_id, $connexion, $region_id_array);

$path = $path_dir . "all_annotations.tab";
insert_annotations($path, $analysis_id, $region_id_array, $connexion);

$path_dest = "/var/www/genotate.life/web/" . "../workspace/storage/{$analysis_id}/";
rename($path_dir, $path_dest) or die("Error on move folder");
update_dataset_status($analysis_id, $connexion);

$encoded_id = get_dataset_encodeid($analysis_id, $connexion);

if (!empty($argv[3])) {
    $email = $argv[3];
    send_email($dataset_name, $encoded_id, $email);
}

send_email($dataset_name, $encoded_id, "analysis@genotate.life");
