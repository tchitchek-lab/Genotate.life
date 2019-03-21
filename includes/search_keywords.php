<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/algorithms_info.php");

$connexion = connect_database();
$service = $_GET['algorithm'];
$dataset = $_GET['dataset'];

$services_info = get_algorithms_info();
$info_service = $services_info[$service];
$description = $info_service['description'];

function get_annotations($service, $dataset, $connexion)
{
    $request = "SELECT annotation.name, GROUP_CONCAT(distinct(SUBSTRING(annotation.description,1,200))) AS description FROM annotation,analysis WHERE algorithm='$service' AND annotation.analysis_id = analysis.analysis_id ";
    if (!empty ($dataset) && $dataset != "") {
        $request .= " AND analysis.analysis_id='{$dataset}' ";
    }
    if (!empty ($dataset) && $dataset != "") {
        $request .= " AND analysis.analysis_id='{$dataset}' ";
    }

    $request .= "GROUP BY name ORDER BY name ";
    $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    return $results;
}

$results = get_annotations($service, $dataset, $connexion);

if (mysqli_num_rows($results) > 0) {
    echo "<div style='width:278px;height:182px;padding:5px;margin:0;'>";
    echo "<div style='width:100%;height:172px;border:1px solid grey;border-radius: 5px;padding:0;margin:0;'>";
    echo "<div style='width:100%;margin:0;display: flex;border-radius:5px;border:none;padding:0;background-color:white;'>";
    echo "<input class='form-control' type='number' id='min_$service' name='min_$service' min='0' max='99' value='1' style='padding:0;margin:0;margin-left:5px;width:4em;border:none;border-radius:0;text-align:right;'>";
    echo "<div data-toggle='tooltip' data-placement='top' title='$description'>";
    echo "<label onclick=\"toggle_names('$service');\" data-toggle='buttons' class='btn btn-default btn-sm' for='$service' style='border:1px solid grey;border-radius:0;width:145px;'>$service";
    echo "<input type='checkbox' name='algorithm[]' id='$service' value='$service' unchecked style='display:none;'></label>";
    echo "</div>";
    echo "<input class='form-control' type='number' id='max_$service' name='max_$service' min='1' max='100' value='100' style='padding:0;margin:0;width:4em;border:none;border-radius:0;text-align:right;'>";
    echo "</div>";
    echo "<div style='width: 100%;height:10em;overflow:auto;'>";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $id = $row ['name'];
        $description = $row ['description'];
        echo "<div data-toggle='tooltip' class='keyword' data-placement='top' title='$id $description' style='width: 100%;'>";
        echo "<label data-toggle='buttons' class='btn btn-default btn-xs' style='width:100%;text-align: center;white-space:normal !important;word-wrap: break-word;border:1px solid grey;margin:0;padding:3px;'>" . $id;
        echo "<input type='checkbox' name='name[]' value='$id' unchecked style='display:none;'></label>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
}
