<?php
if($_GET['service'] && $_GET['color']){
    $service = $_GET['service'];
    $color = "#".$_GET['color'];
    include ("./connect.php");
    $connexion = connectdatabase();
    $request = "UPDATE service SET color = '$color' WHERE name = '$service'";
    $results = mysqli_query($connexion, $request) or die ( "SQL Error:<br>$request_name<br>" . mysqli_error ( $connexion ) );
}
?>
