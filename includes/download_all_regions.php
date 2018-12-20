<?php

function get_all_regions($all_region, $connexion, $type)
{
    $file_name = "";
    $text = "";
    $written_transcripts = array();
    foreach ($all_region as $region_id) {
        if ($region_id == "") {
            exit("error on region_id");
        }
        $request = "SELECT analysis.analysis_id, analysis.name AS dataset_name, relative_region_id, relative_transcript_id, transcript.name AS transcript_name FROM region, transcript, analysis WHERE region.transcript_id=transcript.transcript_id AND region.analysis_id=analysis.analysis_id AND region_id =\"" . $region_id . "\"";
        $results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>" . mysqli_error($connexion));
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);

        $analysis_id = $row['analysis_id'];
        $relative_region_id = $row['relative_region_id'];
        $relative_transcript_id = $row['relative_transcript_id'];
        $transcript_name = $row['transcript_name'];

        if (!empty($type)) {
            if ($type == "annotation") {
                $text .= get_annotations($analysis_id, $transcript_name, $region_id, $connexion);
                $file_name = "annotations.txt";
            }
            if ($type == "protein") {
                $text .= get_proteins(1, $analysis_id, $transcript_name, $relative_region_id);
                $file_name = "proteins.fasta";
            }
            if ($type == "region") {
                $text .= get_regions(1, $analysis_id, $transcript_name, $relative_region_id);
                $file_name = "regions.fasta";
            }
            if ($type == "transcript") {
                $tmp_name = $analysis_id . " " . $transcript_name . " " . $relative_transcript_id;
                if (!in_array($tmp_name, $written_transcripts)) {
                    $text .= get_transcripts(1, $analysis_id, $transcript_name, $relative_transcript_id);
                    $file_name = "transcripts.fasta";
                    array_push($written_transcripts, $tmp_name);
                }
            }
        }
    }
    return array($text, $file_name);
}