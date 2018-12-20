<script src="/js/search.js?v=64856161" xmlns:right></script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/display_computing_info.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/display_exploration_results.php");

$state = "";
$database_id = "";
if (isset($_GET ['encoded_id']) && $_GET ['encoded_id'] != '') {
    $encoded_id = $_GET ['encoded_id'];
    $request = "SELECT * FROM analysis INNER JOIN parameter USING (analysis_id) WHERE encoded_id='$encoded_id' ORDER BY name";
    $results = mysqli_query($connexion, $request) or die ("SQL Error 2 :<br>$request<br>" . mysqli_error($connexion));
    $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
    $database_id = $row ['analysis_id'];
    $state = $row ['status'];
}

if (isset($_GET ['encoded_id']) && $state != "computing" && $state != "complete") {
    echo '<div class="alert alert-danger" style="width:100%">';
    echo 'Dataset not found.';
    echo '</div>';
}

if (!isset($_GET ['encoded_id'])) {
    echo '<div class="alert alert-warning" style="width:100%">';
    echo 'Please run an annotation analysis first.';
    echo '</div>';
}

if ($state == "computing") {
    echo '<div class="alert alert-warning" style="width:100%;text-align: center">';
    echo 'Please wait during the analysis of your dataset.<br>';
    echo "You can access your annotation results using the link: <a href=\""."https://genotate.life/index.php?page=explore_annotations&encoded_id=".$_GET ['encoded_id']."\">https://genotate.life/index.php?page=explore_annotations&encoded_id=".$_GET ['encoded_id']."</a><br>";
    echo '</div>';
    datasets_info($row, $connexion, $database_id,$tooltip_text);
} else if ($state == "complete") {
    display_exploration_results($connexion,$database_id,$tooltip_text);
}
?>

<script>
    document.title = "Genotate.life - Explore annotation results";
</script>
