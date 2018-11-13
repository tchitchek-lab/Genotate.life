

<?php
if (! empty ( $_GET ['dataset_id'] ) && $_GET ['dataset_id'] != '') {
	$dataset_id = $_GET ['dataset_id'];
	$request = "SELECT * FROM dataset INNER JOIN parameters USING (dataset_id) WHERE dataset_id='$dataset_id' ORDER BY name";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	$row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
	include(dirname(__DIR__) . "/includes/datasets_info.php");
	datasets_info($row, $connexion,$dataset_id,$USER_MODE);
}else{
  echo "Specify a dataset id";
}
?>