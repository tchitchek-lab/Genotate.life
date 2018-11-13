<?php
$genotate_dir = dirname(dirname(__DIR__));
$file_path = $genotate_dir . "/web/genotateweb.config.php";
$paths = array();
if ( file_exists($file_path) ) {
	$configfile = fopen($file_path, "r");
	while (!feof($configfile)) {
		$line = fgets($configfile);
		$line=rtrim($line);
		if ($line != ""){
			$splitline = explode(':', $line);
			$paths[$splitline[0]]=$splitline[1];
		}
	}
}
$genotate_jar = $paths['GENOTATE'];
$java = $paths['JAVA'];
$target_dir = $paths['DIR_TMP'] . "/";
$PARALLEL_REGIONS = $paths['PARALLEL_REGIONS'];
$PARALLEL_ANNOTATIONS = $paths['PARALLEL_ANNOTATIONS'];
$PARALLEL_BLAST_PROCESS = $paths['PARALLEL_BLAST_PROCESS'];

include ("./connect.php");
$connexion = connectdatabase();
if (! empty ( $_POST ['debug'] )) {
	echo '<pre>'; print_r($_POST); echo '</pre>';
}
$db_name = $_POST ['db_name'];
if($db_name == ""){
	$db_name = "dataset_" . date ( "Y-m-d_H:i:s" );
}
//CREATE UNIQUE ENCODED ID
$encoded_id = str_shuffle(dechex(date("YmdHis")));
//INSERT INTO dataset
$request = "INSERT INTO dataset(user_id, encoded_id, name, myseq, description, state) VALUES (";
$request .= "'" . $_POST ['user_id']."', ";
$request .= "'$encoded_id', ";
$request .= "'" . $db_name . "', ";
$request .= "'" . $_POST ['myseq']."', ";
$request .= "'" . $_POST ['description'] . "', ";
$request .= "'computing') ";
if (! empty ( $_POST ['debug'] )) {
	echo "<br>".$request;
}
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
$dataset_id = mysqli_insert_id($connexion);
//SEND NOTIFICATION EMAIL
if(isset($_POST['email']) && $_POST['email'] != ""){
	$email=$_POST['email'];
	$message = "Dear user,<br>\r\n
	<br>\r\n
	Thanks for using <a href='http://www.genotate.life'>Genotate</a> transcripts annotation platform.<br>\r\n
	Your database $dataset_name annotation is computing.<br>\r\n
  <a href='https://genotate.life/index.php?page=display&encoded_id=$encoded_id'>https://genotate.life/index.php?page=display&encoded_id=$encoded_id</a><br>\r\n
	<br>\r\n
	Best regards<br>\r\n";
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Genotate <noreply@genotate.life>' . "\r\n";
	
	mail($email, "Genotate - $dataset_name is computing", $message, $headers);
}
//CREATE ANNOTATION SERVICE LIST
$listprogcmd = "";
if (! empty ( $_POST ['SERVICE'] )) {
	foreach ( $_POST ['SERVICE'] as $id ) {
		if (! empty ( $_POST ['checkbox_score_'.$id] )) {
			$score = $_POST ['score_' . $id];
		}else{
			if($_POST ['score_' . $id] == "0.05"){
				$score = 1;
			}else{
				$score = 0;
			}
		}
		$listprogcmd .= $id."[$score],";
	}
}
$listprogsql = $listprogcmd;
if (! empty ( $_POST ['BLASTN'] )) {
	foreach ( $_POST ['BLASTN'] as $id ) {
		$request = "SELECT name FROM blast WHERE blast_id = '$id'";
		$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
		$row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
		$blast_name = $row ['name'];
		if (! empty ( $_POST ['checkbox_identity_'.$id] )) {
			$identity = $_POST ['identity_' . $id];
		}else{
			$identity = 0;
		}
		if (! empty ( $_POST ['checkbox_query_cover_'.$id] )) {
			$query_cover = $_POST ['query_cover_' . $id];
		}else{
			$query_cover = 0;
		}
		if (! empty ( $_POST ['checkbox_subject_cover_'.$id] )) {
			$subject_cover = $_POST ['subject_cover_' . $id];
		}else{
			$subject_cover = 0;
		}
		$listprogcmd .= "BLASTN[" . $id         . ",$identity,$query_cover,$subject_cover],";
		$listprogsql .= "BLASTN[" . $blast_name . ",$identity,$query_cover,$subject_cover],";
	}
}
if (! empty ( $_POST ['BLASTP'] )) {
	foreach ( $_POST ['BLASTP'] as $id ) {
		$request = "SELECT name FROM blast WHERE blast_id = '$id'";
		$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
		$row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
		$blast_name = $row ['name'];
		if (! empty ( $_POST ['checkbox_identity_'.$id] )) {
			$identity = $_POST ['identity_' . $id];
		}else{
			$identity = 0;
		}
		if (! empty ( $_POST ['checkbox_query_cover_'.$id] )) {
			$query_cover = $_POST ['query_cover_' . $id];
		}else{
			$query_cover = 0;
		}
		if (! empty ( $_POST ['checkbox_subject_cover_'.$id] )) {
			$subject_cover = $_POST ['subject_cover_' . $id];
		}else{
			$subject_cover = 0;
		}
		$listprogcmd .= "BLASTP[" . $id         . ",$identity,$query_cover,$subject_cover],";
		$listprogsql .= "BLASTP[" . $blast_name . ",$identity,$query_cover,$subject_cover],";
	}
}
$listprogcmd = rtrim ( $listprogcmd, ", " );
$listprogsql = rtrim ( $listprogsql, ", " );
//INSERT INTO PARAMETERS
$request = "INSERT INTO parameters(start_codons, stop_codons, inner_orf, outside_orf, compute_reverse, compute_ncrna, min_orf_size, services, dataset_id) VALUES (";
$request .= "'" . $_POST ['start_codon'] . "', ";
$request .= "'" . $_POST ['stop_codon'] . "', ";
if (empty ( $_POST ['inner_orf'] )) {
	$request .= "'0', ";
} else {
	$request .= "'1', ";
}
if (empty ( $_POST ['outside_orf'] )) {
	$request .= "'0', ";
} else {
	$request .= "'1', ";
}
if (empty ( $_POST ['compute_reverse'] )) {
	$request .= "'0', ";
} else {
	$request .= "'1', ";
}
if (empty ( $_POST ['compute_ncrna'] )) {
	$request .= "'0', ";
} else {
	$request .= "'1', ";
}
if (empty ( $_POST ['checkbox_orf_min_size'] )) {
	$request .= "'0', ";
} else {
	$request .= "'" . $_POST ['orf_min_size'] . "', ";
}
$request .= "'" . $listprogsql . "', ";
$request .= "'" . $dataset_id . "') ";
if (! empty ( $_POST ['debug'] )) {
	echo "<br>".$request;
}
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
//CREATE TARGET FILE
if ($_POST['myseq'] == 0) {
	$target_file = $target_dir . $dataset_id . ".fasta";
	$file = $_FILES ["file"];
	$tmpfilename = $file ["tmp_name"];
	//$fastaFileType = pathinfo ( $target_file, PATHINFO_EXTENSION );
	if (file_exists ( $target_file )) {
		unlink ( $target_file );
	}
	move_uploaded_file ( $tmpfilename, $target_file );
}else{
	$target_file = $target_dir . $dataset_id . ".fasta";
	file_put_contents ( $target_file, $_POST ['sequence'] ) or die ( "$target_file not  writable" );
}
//UPDATE NUMBER OF SEQUENCES
$size = shell_exec ( "grep '>' {$target_file} | wc -l" );
$request = "UPDATE dataset SET nb_transcripts='$size' WHERE dataset_id=$dataset_id";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
//ADD COMMAND OPTIONS
$options = " -region_by_run $PARALLEL_REGIONS -threads $PARALLEL_ANNOTATIONS -blast_threads $PARALLEL_BLAST_PROCESS ";
if (! empty ( $_POST ['inner_orf'] )) {
	$options .= " -inner_orf";
}
if (! empty ( $_POST ['outside_orf'] )) {
	$options .= " -outside_orf";
}
if (empty ( $_POST ['compute_reverse'] )) {
	$options .= " -ignore_reverse";
}
if (empty ( $_POST ['compute_ncrna'] )) {
	$options .= " -ignore_ncrna";
}
if ($_POST ['kingdom'] == "prokaryote") {
	$options .= " -kingdom prokaryote ";
}else{
	$options .= " -kingdom eukaryote ";
}
if (! empty ( $_POST ['checkbox_orf_min_size'] )) {
	$options .= " -orf_min_size " . $_POST ['orf_min_size'];
}else{
	$options .= " -orf_min_size 0";
}
if (! empty ( $_POST ['start_codon'] )) {
	$start_codon = strtoupper ( $_POST ['start_codon'] );
	$options .= " -start_codon $start_codon";
}
if (! empty ( $_POST ['stop_codon'] )) {
	$stop_codon = strtoupper ( $_POST ['stop_codon'] );
	$options .= " -stop_codon $stop_codon";
}
if (! empty ( $_POST ['debug'] )) {
	$options .= " -services_messages ";
}
//CREATE COMMAND
$cmd_genotate = "$java -jar $genotate_jar -input $target_file -output $target_dir"."$dataset_id $options ";
if ($listprogcmd != ""){
	$cmd_genotate .= " -services $listprogcmd ";
}
$cmd_php_upload .= "php $genotate_dir/web/includes/upload_database.php $dataset_id $db_name {$_POST['email']}";
$cmd = "nohup bash -c \" $cmd_genotate > /dev/null 2>&1 ; $cmd_php_upload > /dev/null 2>&1 \" > /dev/null 2>&1 & echo $!";

if (! empty ( $_POST ['debug'] )) {
	echo "<br>".$cmd_genotate;
	//exec ($cmd_genotate, $messages);
	//echo '<pre>'; print_r($messages); echo '</pre>';
	//echo "<br>".$cmd_php_upload;
	//$messages = array();
	//exec ($cmd_php_upload, $messages);
	//echo '<pre>'; print_r($messages); echo '</pre>';
}else{
	exec($cmd ,$op);
	$pid = $op[0];
	$request = "UPDATE dataset SET pid='$pid' WHERE dataset_id='$dataset_id'";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	echo $dataset_id;
}
?>