<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");

function delete($analysis_id, $connexion)
{
    $cmd = "rm -R " . $_SERVER['DOCUMENT_ROOT'] . "../workspace/storage/{$analysis_id}";
    exec($cmd);

    $request = "DELETE FROM analysis WHERE analysis_id = \"{$analysis_id}\"";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $request = "DELETE FROM parameter WHERE analysis_id = \"{$analysis_id}\"";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $request = "DELETE FROM transcript WHERE analysis_id = \"{$analysis_id}\"";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $request = "DELETE FROM region WHERE analysis_id = \"{$analysis_id}\"";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $request = "DELETE FROM annotation WHERE analysis_id = \"{$analysis_id}\"";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}

$connexion = connect_database();

$request = "SELECT * FROM `analysis` WHERE TIMESTAMPDIFF(DAY,`creation_date`,NOW())>=2 and is_permanent=0";
$results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
    $analysis_id = $row ['analysis_id'];
    delete($analysis_id, $connexion);
}


