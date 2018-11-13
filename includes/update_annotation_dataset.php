<?php
include ("./connect.php");
$connexion = connectdatabase ();
// echo '<pre>'; print_r($_GET); echo '</pre>';
if ($_GET ['action'] == "rename" && $_GET ['new_name'] != "") {
	$request = "UPDATE dataset SET name = '{$_GET['new_name']}' WHERE dataset_id = '{$_GET['dataset_id']}'";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
}
if ($_GET ['action'] == "interrupt") {
	$dataset_id = $_GET ['dataset_id'];
	$request .= "SELECT pid from dataset WHERE dataset_id = {$dataset_id}";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
		$pid = $row ['pid'];
	}
	$cmd = "kill {$pid}";
	exec ( $cmd );
	$request = "UPDATE dataset SET state='interrupted' WHERE dataset_id='{$dataset_id}'";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
}
if ($_GET ['action'] == "delete") {
	$dataset_id = $_GET ['dataset_id'];
	$cmd = "rm -R ".dirname ( dirname ( __DIR__ ) ) . "/workspace/storage/{$dataset_id}";
	exec( $cmd );
	$request = "DELETE FROM dataset WHERE dataset_id = \"{$dataset_id}\"";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	$request = "DELETE FROM parameters WHERE dataset_id = \"{$dataset_id}\"";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	$request = "DELETE FROM transcript WHERE dataset_id = \"{$dataset_id}\"";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	$request = "DELETE FROM region WHERE dataset_id = \"{$dataset_id}\"";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	$request = "DELETE FROM annotation WHERE dataset_id = \"{$dataset_id}\"";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
}
?>