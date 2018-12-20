<?php

function get_datasets_db($connexion)
{
    echo "<div id=\"db_names_div\" style=\"display: none;\">";
    $request = "SELECT name FROM analysis";
    $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $value = "";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $value .= $row ['name'] . ",";
    }
    $value = rtrim($value, ",");
    echo "<input id='db_names' type='hidden' value='{$value}'>";
    echo "</div>";
}

function get_blast_db($connexion)
{
    echo "<div id=\"db_names_div\" style=\"display: none;\">";
    $request = "SELECT name FROM reference";
    $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $value = "";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $value .= $row ['name'] . ",";
    }
    $value = rtrim($value, ",");
    echo "<input id='db_names' type='hidden' value='{$value}'>";
    echo "</div>";
}

