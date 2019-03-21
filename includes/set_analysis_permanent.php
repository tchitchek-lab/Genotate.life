<?php
if(! isset($connexion)){
    include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/tooltips.php");
    $connexion = connect_database();
}
if(isset($_GET['analysis_id'])){
	$analysis_id = $_GET['analysis_id'];
	$request = "UPDATE analysis SET is_permanent = 1 WHERE analysis_id = $analysis_id";
	$results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}
?>

