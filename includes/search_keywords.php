<?php 
include ("connect.php");
$connexion = connectdatabase();
$service = $_GET['service'];
$dataset = $_GET['dataset'];
$user_id = $_GET['user_id'];
include("services_info.php");
$info_service = $services_info[$service];
$description = $info_service['description'];
$request = "SELECT annotation.name, GROUP_CONCAT(distinct(SUBSTRING(annotation.description,1,200))) AS description FROM annotation,dataset WHERE service='$service' AND annotation.dataset_id = dataset.dataset_id ";
if (! empty ( $dataset ) && $dataset != "") {
	$request .= " AND dataset.dataset_id='{$dataset}' ";
}
if (! empty ( $dataset ) && $dataset != "") {
	$request .= " AND dataset.dataset_id='{$dataset}' ";
}

if (! empty ( $user_id ) && $user_id != "") {
	$request .= " AND (user_id = '$user_id' OR user_id = 0) ";
}

$request .= "GROUP BY name ORDER BY name ";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
if (mysqli_num_rows ( $results ) > 0) {
	echo "<div style='width:278px;height:182px;padding:5px;margin:0;'>";
	echo "<div style='width:100%;height:172px;border:1px solid grey;border-radius: 5px;padding:0;margin:0;'>";
	echo "<div style='width:100%;margin:0px;display: flex;border-radius:5px;border:none;padding:0px;background-color:white;'>";
	echo "<input class='form-control' type='number' id='min_$service' name='min_$service' min='0' max='99' value='1' style='padding:0;margin:0;margin-left:5px;width:4em;border:none;border-radius:0px;text-align:right;'>";
	echo "<div data-toggle='tooltip' data-placement='top' title='$description'>";
	echo "<label onclick=\"toggle_names('$service');\" data-toggle='buttons' class='btn btn-default btn-sm' for='$service' style='border:1px solid grey;border-radius:0px;width:145px;'>$service";
	echo "<input type='checkbox' name='service[]' id='$service' value='$service' unchecked style='display:none;'></label>";
	echo "</div>";
	echo "<input class='form-control' type='number' id='max_$service' name='max_$service' min='1' max='100' value='100' style='padding:0;margin:0;width:4em;border:none;border-radius:0px;text-align:right;'>";
	echo "</div>";
	echo "<div style='width: 100%;height:10em;overflow:auto;'>";
  while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
    $id = $row ['name'];
    $description = $row ['description'];
    echo "<div data-toggle='tooltip' class='keyword' data-placement='top' title='$id $description' style='width: 100%;'>";
    echo "<label data-toggle='buttons' class='btn btn-default btn-xs' style='width:100%;text-align: center;white-space:normal !important;word-wrap: break-word;border:1px solid grey;margin:0px;padding:3px;'>" . $id;
    echo "<input type='checkbox' name='name[]' value='$id' unchecked style='display:none;'></label>";
    echo "</div>";
  }
	echo "</div>";
	echo "</div>";
	echo "</div>";
}
?>