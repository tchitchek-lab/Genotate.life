<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");

$connexion = connect_database();

if ($_GET ['action'] == "rename" && $_GET ['new_name'] != "") {
    $new_name = $_GET['new_name'];
    $new_name = preg_replace('/[^A-Za-z0-9\. -]/', '', $new_name);
    $analysis_id = $_GET ['analysis_id'];
    $request = "UPDATE reference SET name = '{$new_name}' WHERE reference_id = '{$analysis_id}'";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}
if ($_GET ['action'] == "delete") {
    $analysis_id = $_GET ['analysis_id'];
    $path = $_SERVER['DOCUMENT_ROOT'] . "../workspace/blastdb/";
    $file1 = $path . $analysis_id . ".nsq";
    $file2 = str_replace(".nsq", ".nhr", $file1);
    $file3 = str_replace(".nsq", ".nin", $file1);
    $file4 = str_replace(".nsq", ".fasta", $file1);
    shell_exec("rm -f $file1 && rm -f $file2 && rm -f $file3 && rm -f $file4");
    $file1 = $path . $analysis_id . ".psq";
    $file2 = str_replace(".psq", ".phr", $file1);
    $file3 = str_replace(".psq", ".pin", $file1);
    $file4 = str_replace(".psq", ".fasta", $file1);
    shell_exec("rm -f $file1 && rm -f $file2 && rm -f $file3 && rm -f $file4");
    $request = "DELETE FROM reference WHERE reference_id='$analysis_id'";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}
