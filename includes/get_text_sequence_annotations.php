<?php
function get_annotation($dataset_id, $transcript_name, $region_id, $connexion) {
	$request = "SELECT * FROM annotation WHERE dataset_id =\"" . $dataset_id . "\" AND region_id =\"" . $region_id . "\"";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
		$text .= $transcript_name . "\t" . $region_id . "\t" . $row ['service'] . "\t" . $row ['name'] . "\t" . $row ['begin'] . "\t" . $row ['end'] . "\t" . $row ['meta'] . "\n";
	}
	return ($text);
}
function get_protein($name, $dataset_id, $transcript_name, $temp_region_id) {
	$path = dirname ( dirname ( __DIR__ ) ) . "/workspace/storage/{$dataset_id}/regions_prot_id.fasta";
	$text = "";
	if (! file_exists ( $path )) {
		die ( "File not found $path" );
	}
	$file_handle = fopen ( $path, "r" );
	$parser = FALSE;
	while ( ! feof ( $file_handle ) ) {
		$line = fgets ( $file_handle );
		if (substr_count ( $line, ">" ) > 0) {
			if ($parser == TRUE) {
				break;
			}
			$region_id_tmp = ( int ) substr ( $line, 1 );
			if ($region_id_tmp == $temp_region_id) {
				$parser = TRUE;
				if ($name) {
					$text .= ">$transcript_name dataset_$dataset_id region_$temp_region_id\n";
				}
			}
		} else if ($parser == TRUE) {
			$text .= $line;
		}
	}
	fclose ( $file_handle );
	return ($text);
}
function get_region($name, $dataset_id, $transcript_name, $temp_region_id) {
	$path = dirname ( dirname ( __DIR__ ) ) . "/workspace/storage/{$dataset_id}/regions_nucl_id.fasta";
	$text = "";
	if (! file_exists ( $path )) {
		die ( "File not found $path" );
	}
	$file_handle = fopen ( $path, "r" );
	$parser = FALSE;
	$i = 0;
	while ( ! feof ( $file_handle ) ) {
		if ($i == $temp_region_id) {
			break;
		}
		fgets ( $file_handle );
		fgets ( $file_handle );
		$i ++;
	}
	if (! feof ( $file_handle )) {
		fgets ( $file_handle );
		if($name){
			$text .= ">$transcript_name dataset_$dataset_id region_$temp_region_id\n";
		}
		$text .= fgets ( $file_handle );
	}
	fclose ( $file_handle );
	return ($text);
}
function get_transcript($name, $dataset_id, $transcript_name, $temp_transcript_id) {
	$path = dirname ( dirname ( __DIR__ ) ) . "/workspace/storage/{$dataset_id}/transcripts.fasta";
	$text = "";
	if (! file_exists ( $path )) {
		die ( "File not found $path" );
	}
	$file_handle = fopen ( $path, "r" );
	$parser = FALSE;
	$i = 0;
	while ( ! feof ( $file_handle ) ) {
		if ($i == $temp_transcript_id) {
			break;
		}
		fgets ( $file_handle );
		fgets ( $file_handle );
		$i ++;
	}
	if (! feof ( $file_handle )) {
		fgets ( $file_handle );
		if($name){
			$text .= ">$transcript_name dataset_$dataset_id transcript_$temp_transcript_id\n";
		}
		$text .= fgets ( $file_handle );
	}
	fclose ( $file_handle );
	return ($text);
}
?>