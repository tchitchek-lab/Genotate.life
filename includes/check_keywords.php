<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");

function check_keywords($dataset, $connexion)
{
    if (isset($dataset) and $dataset != '') {
        $request = "SELECT annotation.name FROM annotation, analysis WHERE annotation.analysis_id = '$dataset' GROUP BY name";
    } else {
        $request = "SELECT annotation.name FROM annotation LEFT JOIN analysis ON (annotation.analysis_id = analysis.analysis_id) GROUP BY name";
    }
    $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));

    if (mysqli_num_rows($results) == 0) {
        echo 'none';
    } else {
        echo 'ok';
    }
}

$connexion = connect_database();

$dataset = $_GET['dataset'];

check_keywords($dataset, $connexion);
