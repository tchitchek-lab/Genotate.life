<script src="/js/display_region.js?v=938436596" xmlns:right></script>

<?php
if(! isset($connexion)){
    include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/tooltips.php");
    $connexion = connect_database();
}
?>

<?php
function page_bar($activepage, $numberpage)
{
    echo "<div style='line-height:30px;height:40px;border:1px solid lightgrey;padding:5px;border-radius:5px;'>";
    echo "<div class='btn-group' style='float:right;'> ";
    echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . 1 . ");\">first page</label>";

    echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . max($activepage - 1, 1) . ");\">&laquo;</label>";
    for ($i = max($activepage - 2, 1); $i <= min($activepage + 2, $numberpage); ++$i) {
        if ($i !== 0) {
            if ($activepage == $i) {
                echo "<label class='btn btn-default active'>$i</label>";
            } else {
                echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . $i . ");\">$i</label>";
            }
        }
    }

    echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . min($activepage + 1, $numberpage) . ");\">&raquo;</label>";
    echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . $numberpage . ");\">last page</label>";
    echo "</div>";
    echo "</div>";
}

function filter_request_service($service, $min, $max)
{
    $request = "AND region.region_id IN (SELECT region_id FROM annotation WHERE algorithm = '$service' ";
    $request .= "GROUP BY(region_id) ";
    $request .= "HAVING COUNT(annotation_id) >= $min ";
    $request .= "AND COUNT(annotation_id) <= $max ";
    $request .= " ) ";
    return ($request);
}

function filter_request_name($name)
{
    $request = "AND region.region_id IN (SELECT distinct(region_id) FROM annotation WHERE name LIKE '%" . rtrim($name) . "%' ) ";
    return ($request);
}

function filter_request_description($description)
{
    $request = "AND region.region_id IN (SELECT distinct(region_id) FROM annotation WHERE description LIKE '%" . rtrim($description) . "%' ) ";
    return ($request);
}

?>

<?php

if (!empty($_POST)) {
    //echo '<pre>'; print_r($_POST); echo '</pre>';
    //CREATE REQUEST
    $current_request = "SELECT ";
    $current_request .= "region_id, ";
    $current_request .= "region.begin AS region_begin, ";
    $current_request .= "region.end AS region_end, ";
    $current_request .= "region.size AS region_size ";
    $current_request .= "FROM region JOIN transcript ON (region.transcript_id = transcript.transcript_id) JOIN analysis ON (region.analysis_id = analysis.analysis_id) ";
    $current_request .= "WHERE 1 ";

    //FILTER
    $filters_request = "";
    if ($_POST['dataset'] != "") {
        $filters_request .= " AND region.analysis_id = '" . $_POST['dataset'] . "' ";
    }
    if (!empty ($_POST ['annotated_only'])) {
        $filters_request .= " AND CONCAT( region.region_id, ':' ,region.analysis_id ) IN (SELECT CONCAT( region_id, ':' ,analysis_id ) FROM annotation) ";
    }
    if ($_POST ['annotated_only_filter'] == 'true') {
        $filters_request .= " AND CONCAT( region.region_id, ':' ,region.analysis_id ) IN (SELECT CONCAT( region_id, ':' ,analysis_id ) FROM annotation) ";
    }
    if ($_POST ['coding_only_filter'] == 'true') {
        $filters_request .= " AND region.coding = 'coding' ";
    }
    if ($_POST ['noncoding_only_filter'] == 'true') {
        $filters_request .= " AND region.coding = 'noncoding' ";
    }

    if (!empty ($_POST ['name'])) {
        foreach ($_POST['name'] as $name) {
            $filters_request .= filter_request_name($name);
        }
    }

    if (!empty ($_POST ['algorithm'])) {
        foreach ($_POST['algorithm'] as $service) {
            $filters_request .= filter_request_service($service, $_POST['min_' . $service], $_POST['max_' . $service]);
        }
    }
  
    $current_request .= $filters_request;
    $current_request .= " ORDER BY region_size DESC";

    ?>

    <div style='padding:5px;width:100%;'></div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/display_annotation_results_summary.php");?>

    <div style='padding:5px;width:100%;'></div>

    <?php
    $nbresultbypage = 20;
    $windownumberpage = ceil(intval($nb_regions) / $nbresultbypage);
    $activepage = $_POST["activepage"];
    $request = $current_request . " LIMIT " . (($activepage - 1) * $nbresultbypage) . " , " . $nbresultbypage;
    $results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>" . mysqli_error($connexion));

    //DISPLAY RESULTS
    echo "<div id='results_header_div' style='width:100%;margin-bottom:10px;'>";
    page_bar($activepage, $windownumberpage);
  
    echo "<div style='float:right;line-height:30px;height:40px;border:1px solid lightgrey;padding:5px;border-radius:5px;'>";
    echo "<div class='btn-group'> ";
    echo "<span data-toggle='tooltip' data-placement='top' title='{$tooltip_text['coding_only_filter']}'><label class='btn btn-default";
    if ($_POST ['coding_only_filter'] == 'true') { echo ' active';}
    echo "' onclick=\"$('#coding_only_filter').val(! {$_POST ['coding_only_filter']});reloadphp_div(" . 1 . ");\">coding only</label></span>";
    echo "<span data-toggle='tooltip' data-placement='top' title='{$tooltip_text['noncoding_only_filter']}'><label class='btn btn-default";
    if ($_POST ['noncoding_only_filter'] == 'true') { echo ' active';}
    echo "' onclick=\"$('#noncoding_only_filter').val(! {$_POST ['noncoding_only_filter']});reloadphp_div(" . 1 . ");\"  style=''>non-coding only</label></span>";
    echo "<span data-toggle='tooltip' data-placement='top' title='{$tooltip_text['annotated_only_filter']}'><label class='btn btn-default";
    if ($_POST ['annotated_only_filter'] == 'true') { echo ' active';}
    echo "' onclick=\"$('#annotated_only_filter').val(! {$_POST ['annotated_only_filter']});reloadphp_div(" . 1 . ");\"  style=''>annotated only</label></span>";
    echo "</div>";
    echo "</div>";
  ?>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});
    })
</script>
<?php
    echo "<div style='display:none;line-height:30px;float:right;height:40px;border:1px solid lightgrey;padding:5px;'>";
    echo "<label style='margin-right:5px;'>order by</label>";
    echo "<div class='btn-group' style='float:right;'>";
    if (empty($_POST['order']) || $_POST['order'] == 'length') {
        echo "<label class='btn btn-default active' for='length'>";
        echo "<input id='length' value='length' type='radio' name='order' form='search' style='display:none' onchange='order_update()' checked>";
        echo "length</label>";
    } else {
        echo "<label class='btn btn-default' for='length'>";
        echo "<input id='length' value='length' type='radio' name='order' form='search' style='display:none' onchange='order_update()'>";
        echo "length</label>";
    }
    if (isset($_POST['order']) && $_POST['order'] == 'begin') {
        echo "<label class='btn btn-default active' for='begin'>";
        echo "<input id='begin' value='begin' type='radio' name='order' form='search' style='display:none' onchange='order_update()' checked>";
        echo "begin</label>";
    } else {
        echo "<label class='btn btn-default' for='begin'>";
        echo "<input id='begin' value='begin' type='radio' name='order' form='search' style='display:none' onchange='order_update()'>";
        echo "begin</label>";
    }
    if (isset($_POST['order']) && $_POST['order'] == 'end') {
        echo "<label class='btn btn-default active' for='end'>";
        echo "<input id='end' value='end' type='radio' name='order' form='search' style='display:none' onchange='order_update()' checked>";
        echo "end</label>";
    } else {
        echo "<label class='btn btn-default' for='end'>";
        echo "<input id='end' value='end' type='radio' name='order' form='search' style='display:none' onchange='order_update()'>";
        echo "end</label>";
    }
    echo "</div></div>";
    echo "</div>";
    ?>

    <?php
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $region_id = $row['region_id'];
        echo "<div id='viewer_div_$region_id' style='width:100%;'></div>";
        echo "\n<script>";
        echo "\n$(document).ready(function(){";
        echo "\n    var xhr = new XMLHttpRequest();";
        echo "\n    xhr.open ('GET', '/includes/display_region.php?region_id=$region_id', true);";
        echo "\n    xhr.onreadystatechange = function() {";
        echo "\n        if(xhr.readyState == 4 && xhr.status == 200) {";
        echo "\n    	    var div = document.getElementById('viewer_div_$region_id');";
        echo "\n    		div.innerHTML = xhr.responseText;";
        echo "\n            $('.checkbox_$region_id').on('change', function() { $('#button_$region_id').click(); });";
        echo "\n            $(document).ready(function(){";
        echo "\n            		$('#button_$region_id').click();";
        echo "\n            	},10);";
        echo "\n            	$('.button_$region_id').click(function(){";
         echo "\n            		create_svg('$region_id');";
        echo "\n            	});";
        echo "\n        }";
        echo "\n    }";
        echo "\n    xhr.send(null);";
        echo "\n});";
        echo "\n</script>";
    }
    page_bar($activepage, $windownumberpage);
    ?>

    <?php
}
?>