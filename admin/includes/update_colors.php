<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");
$connexion = connect_database();

if ($_GET['service'] && $_GET['color']) {
    $service = $_GET['service'];
    $color = "#" . $_GET['color'];
    $request = "UPDATE service SET color = '$color' WHERE name = '$service'";
    $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}
