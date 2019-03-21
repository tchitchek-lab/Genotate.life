<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/tooltips.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/algorithms_info.php");
?>


<?php
function display_exploration_results($connexion,$analysis_id, $tooltip_text){
?>

<label type=title>Explore annotation results</label>
<p style='text-align: justify;text-justify: inter-word;'>
    You can search here for transcript sequences having specific predicted annotations. Search parameters includes the annotation type, annotation name, the number of identified annotations all either at the nucleic or proteic levels.
</p>

<form action="/index.php?page=explore_annotation_results&encoded_id=<?php echo $_GET['encoded_id']; ?>" method="post" id="search" name="search">

    <?php
    if (isset($_GET ['encoded_id']) && $_GET ['encoded_id'] != '') {
        $encoded_id = $_GET ['encoded_id'];
        $request = "SELECT * FROM analysis INNER JOIN parameter USING (analysis_id) WHERE encoded_id='$encoded_id' ORDER BY name";
        $results = mysqli_query($connexion, $request) or die ("SQL Error 2 :<br>$request<br>" . mysqli_error($connexion));
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
        $analysis_id = $row ['analysis_id'];
    }
    ?>
    <input type='hidden' name='encoded_id' id='encoded_id' value='<?php echo $_GET['encoded_id']; ?>'>
    <input type='hidden' name='dataset' id='dataset' value='<?php echo $analysis_id; ?>'>
  
    <div id="annotations_filters" style="width: 100%;">
        <div class="div-border-title">
            Annotation keywords
            <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top"
               href="/index.php?page=tutorial" target="_blank"
               title="<?php echo $tooltip_text['keyword_filter']; ?>">
                <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'>
            </a>
        </div>

        <div id="filters_div" class='div-border' style="width: 100%;padding:5px;margin-bottom:10px;">
            <div class='div-border' style="margin:0;padding:0;width: 100%;">
                <input form='' type='text' id='annotation_keyword_filter' name='annotation_keyword_filter'
                       placeholder='type a keyword to filter annotation results'
                       style='margin:0;height:30px;padding:5px;width:100%' onkeyup='keyword_refresh();'>
            </div>

            <!-- <button type=button style='width:31px;height:31px;padding:5px;margin-left:4px' data-toggle='tooltip'
                    data-placement='top' title='click or press enter to refresh avaiable annotations'
                    class='btn btn-default' onclick='keyword_refresh();'><span
                    class='glyphicon glyphicon-refresh'></span></button> -->
        </div>

        <div class="div-border-title">
            Annotation features
            <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top"
               href="/index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['keyword_filter']; ?>">
                <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'>
            </a>
        </div>

        <div class='div-border' style="margin:0;padding:0;width: 100%;">
            <?php
            $services_info = get_algorithms_info();
            foreach ($services_info as $service => $info_service) {
                echo "<div class='div_keywords' id='div_names_$service'></div>";
            }
            ?>
            <script>dataset_refresh($('#dataset').val());</script>
        </div>

    <button name="submit_search_form" id="submit_search_form" style="width: 100%; font-size: 1.3em;margin-top:10px;" class="btn btn-secondary active">Search sequences</button>
    <input type='hidden' name='activepage' id='activepage' value='1'>
    <input type='hidden' name='coding_only_filter' id='coding_only_filter' value='0'>
    <input type='hidden' name='noncoding_only_filter' id='noncoding_only_filter' value='0'>
    <input type='hidden' name='annotated_only_filter' id='annotated_only_filter' value='0'>
</form>

<div id="search_display_div" style='width: 100%;margin-top:10px;'></div>
<canvas id="canvas" width="0" height="0" style='display: none;'></canvas>

    <?php
}
?>