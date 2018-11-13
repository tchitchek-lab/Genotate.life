<?php
include ("./connect.php");
$connexion = connectdatabase ();
// echo '<pre>'; print_r($_GET); echo '</pre>';
if ($_GET ['action'] == "rename" && $_GET ['new_name'] != "") {
	$dataset_id = $_GET ['dataset_id'];
	$path = dirname ( dirname ( __DIR__ ) ) . "/workspace/blastdb/";
	$request = "UPDATE blast SET name = '{$_GET['new_name']}' WHERE blast_id = '{$dataset_id}'";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
}
if ($_GET ['action'] == "delete") {
	$dataset_id = $_GET ['dataset_id'];
	$file = dirname ( dirname ( __DIR__ ) ) . "/workspace/blastdb/" . $dataset_id . ".nsq";
	$file2 = str_replace ( ".nsq", ".nhr", $file );
	$file3 = str_replace ( ".nsq", ".nin", $file );
	$file4 = str_replace ( ".nsq", ".fasta", $file );
	echo "rm $file && rm $file2 && rm $file3 && rm $file4";
	shell_exec ( "rm $file && rm $file2 && rm $file3 && rm $file4" );
	$request = "DELETE FROM blast WHERE blast_id='$dataset_id'";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
}
?>