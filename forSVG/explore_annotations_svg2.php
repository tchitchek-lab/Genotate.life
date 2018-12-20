<script src="/js/search.js?v=64856161" xmlns:right></script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/services_info.php");
?>

<form action="/index.php?page=explore_annotation_results&encoded_id=<?php echo $_GET['encoded_id']; ?>" method="post" id="search" name="search">

    <input type='hidden' name='encoded_id' id='encoded_id' value=''>
    <input type='hidden' name='dataset' id='dataset' value=''>
  
    <div id="annotations_filters" style="width: 100%;">

        <div id="filters_div" class='div-border' style="width: 100%;padding:5px;margin-bottom:10px;">
            <div class='div-border' style="margin:0;padding:0;width: 95%;">
                <input form='' type='text' id='annotation_keyword_filter' name='annotation_keyword_filter'
                       placeholder='type a keyword to filter annotation results'
                       style='margin:0;height:30px;padding:5px;width:100%'>
            </div>

            <button type=button style='width:31px;height:31px;padding:5px;margin-left:4px' data-toggle='tooltip'
                    data-placement='top' title='click or press enter to refresh avaiable annotations'
                    class='btn btn-default' onclick='keyword_refresh();'><span
                    class='glyphicon glyphicon-refresh'></span></button>
        </div>

        <div class="div-border-title">
            Annotation features
            <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top"
               href="/index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['keyword_filter']; ?>">
                <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'>
            </a>
        </div>

        <div class='div-border' style="margin:0;padding:0;width: 100%;">
            <div style="width: 100%; padding: 5px; margin: 0; ">
          <span data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['annotated_only']; ?>"
                style="width: 100%; float: left;"> <label data-toggle='buttons' class='btn btn-default active'
                                                          for="ncRNA" style="width: 100%;">
              <input type="checkbox" id="annotated_only" name="annotated_only" checked style='display: none;'>
              annotated transcript(s) only
            </label>
          </span>
            </div>
            <?php
            $services_info = get_services_info();
            foreach ($services_info as $service => $info_service) {
                echo "<div class='div_keywords' id='div_names_$service'></div>";
            }
            ?>
            <script>dataset_refresh($('#dataset').val());</script>
        </div>

    <button name="submit_search_form" id="submit_search_form" style="width: 100%; font-size: 1.3em;margin-top:10px;" class="btn btn-secondary active">Search sequences</button>
    <input type='hidden' name='activepage' id='activepage' value='1'>
</form>

<div id="search_display_div" style='width: 100%;margin-top:10px;'></div>
<canvas id="canvas" width="0" height="0" style='display: none;'></canvas>


<script>
    document.title = "Genotate.life - Explore annotation results";
</script>
