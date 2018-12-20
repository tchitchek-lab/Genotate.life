<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");

$connexion = connect_database();

if ($_GET ['action'] == "rename" && $_GET ['new_name'] != "") {
    $new_name = $_GET['new_name'];
    $new_name = preg_replace('/[^A-Za-z0-9\. -]/', '', $new_name);
    $analysis_id = $_GET['analysis_id'];
    $request = "UPDATE analysis SET name = '{$new_name}' WHERE analysis_id = '{$analysis_id}'";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}
if ($_GET ['action'] == "interrupt") {
    $analysis_id = $_GET ['analysis_id'];
    $request = "SELECT pid from analysis WHERE analysis_id = {$analysis_id}";
    $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $pid = NULL;
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $pid = $row ['pid'];
    }
    $cmd = "kill {$pid}";
    exec($cmd);
    $request = "UPDATE analysis SET status='interrupted' WHERE analysis_id='{$analysis_id}'";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}
if ($_GET ['action'] == "delete") {
    $analysis_id = $_GET ['analysis_id'];
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
