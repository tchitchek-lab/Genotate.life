<?php

$encoded_id = $_GET ['encoded_id'];
$request = "SELECT * FROM analysis INNER JOIN parameter USING (analysis_id) WHERE encoded_id='$encoded_id' ORDER BY name";
$results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
$database_id = $row ['analysis_id'];

if ($row == null) {
    echo '<div class="alert alert-warning" style="width:100%">';
    echo "Unknown dataset id";
    echo '</div>';
    return;
}

include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/display_computing_info.php");
datasets_info($row, $connexion,$database_id,$tooltip_text);
