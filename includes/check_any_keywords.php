<?php 
include ("connect.php");
$connexion = connectdatabase();
$service = $_GET['service'];
$dataset = $_GET['dataset'];
$user_id = $_GET['user_id'];
$request = "SELECT annotation.name FROM annotation LEFT JOIN dataset ON (annotation.dataset_id = dataset.dataset_id) WHERE ( user_id = '$userid' or user_id = 0 ) GROUP BY name";
if(isset($dataset) and $dataset != ''){ 
    $request = "SELECT annotation.name FROM annotation, dataset WHERE annotation.dataset_id = '$dataset' AND ( user_id = '$userid' or user_id = 0 ) GROUP BY name";
}
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
$display='';
if (mysqli_num_rows ( $results ) == 0) {
  echo 'none';
}
else{
  echo 'ok';
}
?>