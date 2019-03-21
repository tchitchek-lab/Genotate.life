<style>
    rect:hover {
        stroke: black;
        fill-opacity: 0.9;
    }
</style>

<script src="/js/display_region.js?v=15641546" xmlns:right></script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/get_sequences.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");

$connexion = connect_database();

$svg_default_width = 836;
$path_includes = "includes/";

$region_id = $_GET['region_id'];
if (isset($_GET['viewer'])){
$mode = "JS";
$svg_default_width = "100%";
$path_includes = "";
?>

<html>
<head>

    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <!--[if IE]>
    <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico"/><![endif]-->

    <script src="/js/jquery-2.2.2.min.js?v=5165161968416"></script>
    <script src="/js/bootstrap.min.js?v=5165161968416"></script>
    <script src="/js/create_svg.js?v=5165161968416"></script>

    <link rel="stylesheet" media="screen" type="text/css" href="/css/bootstrap.min.css?v=5165161968416">
    <link rel="stylesheet" media="screen" type="text/css" href="/css/bootstrap-theme.min.css?v=5165161968416">
    <link rel="stylesheet" media="screen" type="text/css" href="/css/header.css?v=5165161968416">
    <link rel="stylesheet" media="screen" type="text/css" href="/css/button.css?v=5165161968416">
    <link rel="stylesheet" media="screen" type="text/css" href="/css/div.css?v=5165161968416">
    <link rel="stylesheet" media="screen" type="text/css" href="/css/element.css?v=5165161968416">
    <link rel="stylesheet" media="screen" type="text/css" href="/css/input.css?v=5165161968416">
    <link rel="stylesheet" media="screen" type="text/css" href="/css/table.css?v=5165161968416">
    <link rel="stylesheet" media="screen" type="text/css" href="/css/slider.css?v=5165161968416">
    <link rel="stylesheet" media="screen" type="text/css" href="/css/range.css?v=5165161968416">

    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>

</head>
<body id="body">
<div id="content_scroll" style='height: 100%;'>
    <div id="content" style='padding:10px;'>
        <?php
        }

        $current_request = "SELECT ";
        $current_request .= "region_id, ";
        $current_request .= "region.begin AS region_begin, ";
        $current_request .= "region.end AS region_end, ";
        $current_request .= "region.size AS region_size, ";
        $current_request .= "region.strand AS region_strand, ";
        $current_request .= "region.coding AS region_coding, ";
        $current_request .= "region.type AS region_type, ";
        $current_request .= "region.transcript_id AS transcript_id, ";
        $current_request .= "region.analysis_id AS analysis_id, ";
        $current_request .= "region.relative_region_id AS relative_region_id, ";
        $current_request .= "transcript.name AS transcript_name, ";
        $current_request .= "transcript.description AS transcript_desc, ";
        $current_request .= "transcript.size AS transcript_size, ";
        $current_request .= "transcript.relative_transcript_id AS relative_transcript_id, ";
        $current_request .= "analysis.name AS dataset_name ";
        $current_request .= "FROM region, transcript, analysis ";
        $current_request .= "WHERE region.transcript_id = transcript.transcript_id ";
        $current_request .= "AND region.analysis_id = analysis.analysis_id ";
        $current_request .= "AND region.region_id = '$region_id' ";

        $results = mysqli_query($connexion, $current_request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);

        $annotations = array();
        $request_annot = "SELECT * FROM annotation WHERE region_id=$region_id ORDER BY algorithm, begin";
        $results_annot = mysqli_query($connexion, $request_annot) or die("SQL Error:<br>" . $request_annot . "<br>" . mysqli_error($connexion));
        while ($row_annot = mysqli_fetch_array($results_annot, MYSQLI_ASSOC)) {
            $annotation = array();
            $annotation['algorithm'] = $row_annot['algorithm'];
            $annotation['name'] = $row_annot['name'];
            $annotation['begin'] = $row_annot['begin'];
            $annotation['end'] = $row_annot['end'];
            $annotation['description'] = $row_annot['description'];
            $services_annot[$row_annot['annotation_id']] = $annotation;
        }

        $services_color = array();
        $request_color = "SELECT * from algorithm";
        $results_color = mysqli_query($connexion, $request_color) or die ("SQL Error:<br>$request_color<br>" . mysqli_error($connexion));
        while ($row_color = mysqli_fetch_array($results_color, MYSQLI_ASSOC)) {
            $services_color[$row_color['name']] = $row_color['color'];
        }
        $services_color_ser = json_encode($services_color);

        $rowser = $row;
        foreach ($rowser as $key => $value) {
            $value = str_replace(' ', '_', $value);
            $value = str_replace('|', '_', $value);
            $rowser[$key] = preg_replace('/[^A-Za-z0-9\-_\.:=]/', '', $value);
        }
        $rowser = json_encode($rowser);

        if (isset($services_annot)) {
            $services_annot_ser = $services_annot;
            foreach ($services_annot_ser as $key => $value) {
                $value = str_replace(' ', '_', $value);
                $value = str_replace('|', '_', $value);
                $services_annot_ser[$key] = preg_replace('/[^A-Za-z0-9\-_\.:=]/', '', $value);
            }
            $services_annot_ser = json_encode($services_annot_ser);
        }

        $relative_region_id = $row ['relative_region_id'];
        $relative_transcript_id = $row ['relative_transcript_id'];
        $region_size = $row ['region_size'];
        $analysis_id = $row ['analysis_id'];
        $region_begin = $row ['region_begin'];
        $region_end = $row ['region_end'];
        $region_coding = $row ['region_coding'];
        $region_type = $row ['region_type'];
        $dataset_name = $row ['dataset_name'];
        $transcript_name = $row ['transcript_name'];
        $transcript_desc = $row ['transcript_desc'];
        $transcript_size = $row ['transcript_size'];
        $region_strand = $row ['region_strand'];

        $transcript_seq = get_transcripts(0, $analysis_id, $transcript_name, $relative_transcript_id);
        $region_seq = get_regions(0, $analysis_id, $transcript_name, $relative_region_id);
        if ($region_coding != "noncoding") {
            $prot_seq = get_proteins(0, $analysis_id, $transcript_name, $relative_region_id);
        }
        $svgtext = "";
        $nbrec = mb_substr_count($svgtext, "<rect");
        $height = ($nbrec + 1.5) * 18;
        echo "<div id='region_viewer_$region_id' style='width:100%;background-color:white;margin-bottom:20px;'>";
        echo "<form action='javascript:void(0);' method='post' id='update_svg_$region_id'>";
        if ($region_strand == "+") {
            $region_strand_text = "positive";
        }else{
            $region_strand_text = "negative complement";
        }

        if ($region_coding == "coding") {
            echo "<div class='div-border-title'>$region_type coding ORF of " . number_format($region_size, 0, '.', ',') . " bases on transcript " . substr($transcript_name, 0, 15) . " ({$region_strand_text} strand) ";
        } else {
            echo "<div class='div-border-title' style='background-color:grey;'>potential non-coding RNA of " . number_format($region_size, 0, '.', ',') . " bases on transcript " . substr($transcript_name, 0, 15) . " ({$region_strand_text} strand) ";
        }
        echo "<button onclick=\"viewer('$region_id',$('#region_viewer_$region_id').width(),$('#region_viewer_$region_id').height()+100);\" class='btn btn-sm btn-info' style='height:30px;width:30px;border:none;float:right;color: #fff;font-size:15px;'><span class='glyphicon glyphicon-resize-full' aria-hidden='true'></span></button>";
        echo "</div>";
        echo "<div class='div-border' style='width:100%;'>";

        if (empty($transcript_seq)) $transcript_seq = "";
        if (empty($prot_seq)) $prot_seq = "";
        if (empty($svg_default_width)) $svg_default_width = "";
        if (empty($rowser)) $rowser = "";
        if (empty($services_annot_ser)) $services_annot_ser = ""; //
        if (empty($services_color_ser)) $services_color_ser = ""; //

        echo "<input type='hidden' name='transcript_seq' id='transcript_seq_$region_id' value=$transcript_seq>";
        echo "<input type='hidden' name='prot_seq' id='prot_seq_$region_id' value=$prot_seq>";
        echo "<input type='hidden' name='svg_default_width' id='svg_default_width_$region_id' value=$svg_default_width>";
        echo "<input type='hidden' name='row' id='row_$region_id' value=$rowser>";
        echo "<input type='hidden' name='services_annot' id='services_annot_$region_id' value=$services_annot_ser>";
        echo "<input type='hidden' name='services_color' id='services_color_$region_id' value=$services_color_ser>";

        // TRANSCRIPT DESCRIPTION
        echo "<div data-toggle='buttons' style='width:100%;'>$transcript_name $transcript_desc</div>";

        // SERVICES SECTION
        echo "<div data-toggle='buttons' style='width:100%;'>";
        $services = array();
        $request = "SELECT distinct(algorithm) FROM annotation WHERE region_id='$region_id' ORDER BY algorithm";
        $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
        while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
            $service = $row ['algorithm'];
            array_push($services, $service);
            echo "<label id='{$service}_{$region_id}' class='btn btn-xs btn-default active'>";
            echo "<input style='display:none;' class='checkbox_$region_id' type='checkbox' name='services[]' id='$service' value='$service' checked>$service</label>";
        }
        echo "</div>";

        // SLIDER SECTION
        $min = 1;
        echo "<div style='width: 100%;background: rgba(0, 0, 0, 0.1)'>";
        echo "	<button onclick=\"move_left('$region_id','$transcript_size','100');\" class='btn btn-xs btn-default' style='width:25px;height:20px; float: left;border-radius:0;'><<<</button>";
        echo "	<button onclick=\"move_left('$region_id','$transcript_size','30');\" class='btn btn-xs btn-default' style='width:20px;height:20px; float: left;border-radius:0;'><<</button>";
        echo "	<button onclick=\"move_left('$region_id','$transcript_size','1');\" class='btn btn-xs btn-default' style='width:20px;height:20px; float: left;border-radius:0;'><</button>";
        echo "	<input name='amount_lower_$region_id' id='amount_lower_$region_id' for='range_lower' style='width:50px;height:20px;text-align:center;border-radius:0;' readonly value=$min>";
        echo "	<div style='margin-top: 9px;width:600px;height:11px;'>";
        echo "		<input style='float: left; width: 97%; padding: 0;margin-right:3%;border:none;' type='range' id='range_lower_$region_id' name='range_lower' class='range_lower' value=$min min=$min max=" . ($transcript_size - 99) . " oninput=\"onchange_range('$region_id','$transcript_size');\">";
        echo "		<input style='float: left; width: 10%; padding: 0;margin-left:45%;border:none;' type='range' id='range_slider_$region_id' name='range_slider' class='range_slider' value=0 min=-1 max=1 oninput=\"slide_region('$region_id','$transcript_size',this.value)\">";
        echo "		<input style='float: left; width: 97%; padding: 0;margin-left:3%;border:none;' type='range' id='range_upper_$region_id' name='range_upper' class='range_upper' value=$transcript_size min=" . ($min + 99) . " max=$transcript_size oninput=\"onchange_range('$region_id','$transcript_size');\">";
        echo "	</div>";
        echo "	<input name='amount_upper_$region_id' id='amount_upper_$region_id' for='range_upper' style='width:50px;height:20px;text-align:center;border-radius:0;' readonly value=$transcript_size>";
        echo "	<button onclick=\"move_right('$region_id','$transcript_size','100');\" class='btn btn-xs btn-default' style='width:25px;height:20px; float: right;border-radius:0;'>>>></button>";
        echo "	<button onclick=\"move_right('$region_id','$transcript_size','30');\" class='btn btn-xs btn-default' style='width:20px;height:20px; float: right;border-radius:0;'>>></button>";
        echo "	<button onclick=\"move_right('$region_id','$transcript_size','1');\" class='btn btn-xs btn-default' style='width:20px;height:20px; float: right;border-radius:0;'>></button>";
        echo "</div>";

        // SVG SECTION
        $mode = "nophp";
        if ($mode == "PHP") {
            echo "<button name='button_$region_id' id='button_$region_id' class='button_$region_id' style='display:none;' onclick=\"refresh_svg($region_id);\">Refresh SVG</button>";
        } else {
            echo "<button name='button_$region_id' id='button_$region_id' class='button_$region_id' style='display:none;' onclick=\"create_svg('$region_id');\">Refresh SVG</button>";
        }

        echo "</form>";
        echo "<div id='svg_div_$region_id' style='margin:0px;padding:0px;overflow:hidden;overflow-y:auto;width:100%;max-height:30em;' onwheel=\"wheel_svg_zoom('$region_id','$transcript_size');\"></div>";

        echo "<script>";
        echo "$('.checkbox_$region_id').on('change', function() { $('#button_$region_id').click(); });";
        echo "$(document).ready(function(){";
        echo "	setTimeout(function() {";
        echo "		$('#button_$region_id').click();";
        echo "	},10);";
        echo "	$('.button_$region_id').click(function(){";
        echo "		create_svg('$region_id');";
        echo "	});";
        echo "});";
        echo "</script>";

        //BELOW SVG
        echo "<form name='transcript' id='transcript_$region_id' action='./{$path_includes}download_sequences.php?type=transcript' method='post' target=\"_blank\">";
        echo "<input type='hidden' name='analysis_id' value=$analysis_id>";
        echo "<input type='hidden' name='dataset_name' value=$dataset_name>";
        echo "<input type='hidden' name='transcript_name' value=$transcript_name>";
        echo "<input type='hidden' name='relative_transcript_id' value=$relative_transcript_id></form>";

        echo "<form name='region' id='region_$region_id' action='./{$path_includes}download_sequences.php?type=region' method='post' target=\"_blank\">";
        echo "<input type='hidden' name='analysis_id' value=$analysis_id>";
        echo "<input type='hidden' name='dataset_name' value=$dataset_name>";
        echo "<input type='hidden' name='transcript_name' value=$transcript_name>";
        echo "<input type='hidden' name='relative_region_id' value=$relative_region_id></form>";

        if ($region_coding != "noncoding") {
            echo "<form name='protein' id='protein_$region_id' action='./{$path_includes}download_sequences.php?type=protein' method='post' target=\"_blank\">";
            echo "<input type='hidden' name='analysis_id' value=$analysis_id>";
            echo "<input type='hidden' name='dataset_name' value=$dataset_name>";
            echo "<input type='hidden' name='transcript_name' value=$transcript_name>";
            echo "<input type='hidden' name='relative_region_id' value=$relative_region_id></form>";
        }

        if(count($results_annot)>1){
            echo "<form name='annotation' id='annotation_$region_id' action='./{$path_includes}download_sequences.php?type=annotation' method='post' target=\"_blank\">";
            echo "<input type='hidden' name='analysis_id' value=$analysis_id>";
            echo "<input type='hidden' name='dataset_name' value=$dataset_name>";
            echo "<input type='hidden' name='transcript_name' value=$transcript_name>";
            echo "<input type='hidden' name='region_id' value=$region_id></form>";
        }

        echo "<form name='annotation' id='BLAST_NUCL_$region_id' action='https://blast.ncbi.nlm.nih.gov/Blast.cgi?PAGE_TYPE=BlastSearch' method='post' target=\"_blank\">";
        echo "<input type='hidden' name='QUERY' value=$region_seq>";
        echo "<input type='hidden' name='JOB_TITLE' value={$transcript_name}_{$region_id}></form>";

        if ($region_coding != "noncoding") {
            echo "<form name='annotation' id='BLASTP_$region_id' action='https://blast.ncbi.nlm.nih.gov/Blast.cgi?PAGE=Proteins' method='post' target=\"_blank\">";
            echo "<input type='hidden' name='QUERY' value=$prot_seq>";
            echo "<input type='hidden' name='JOB_TITLE' value={$transcript_name}_{$region_id}></form>";
        }
        ?>

        <div class="dropdown" style='float: right;'>
            <button class="btn btn-xs btn-default dropdown-toggle" type="button" data-toggle="dropdown"
                    style='width: 11em;'>
                download&emsp;<span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <?php
                if ($region_coding == "coding") {
                    echo "<li><a href=\"javascript:document.getElementById('transcript_$region_id').submit();\">transcript sequence</a></li>";
                    echo "<li><a href=\"javascript:document.getElementById('region_$region_id').submit();\">ORF sequence</a></li>";
                    echo "<li><a href=\"javascript:document.getElementById('protein_$region_id').submit();\">protein sequence</a></li>";
                } else {
                    echo "<li><a href=\"javascript:document.getElementById('region_$region_id').submit();\">transcript sequence</a></li>";
                }
                if(count($results_annot)>1) {
                    echo "<li><a href=\"javascript:document.getElementById('annotation_$region_id').submit();\">annotations</a></li>";
                }
                echo "<li><button class='list-group-item' style='height:26px;padding:0;padding-left:20px;border:none;color:#262626;' onclick=\"download_svg('{$transcript_name}_{$region_id}.svg','svg_div_content_$region_id');\">SVG representation</button></li>";
                //echo "<li><button class='list-group-item' style='height:26px;padding:0;padding-left:20px;border:none;color:#262626;' onclick=\"download_png('{$transcript_name}_{$region_id}.png','svg_$region_id');\">PNG representation</button></li>";
                ?>
            </ul>
        </div>
        <div class="dropdown" style='float: right;'>
            <button class="btn btn-xs btn-default dropdown-toggle" type="button" data-toggle="dropdown"
                    style='width: 11em;'>
                BLAST sequence&emsp;<span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <?php
                echo "<li><a href=\"javascript:document.getElementById('BLAST_NUCL_$region_id').submit();\">nucleic sequence</a></li>";
                if ($region_coding != "noncoding") {
                    echo "<li><a href=\"javascript:document.getElementById('BLASTP_$region_id').submit();\">protein sequence</a></li>";
                }
                ?>
            </ul>
        </div>
        <div class='dropdown' style='float: right;'>
            <?php
            echo "<button id='details_toggle_$region_id' name='details_toggle_$region_id' class='btn btn-xs btn-default dropdown-toggle' type='button' data-toggle='dropdown' style='width: 11em;'>annotation details&emsp;<span class='caret'></span></button>";
            ?>
            <ul class='dropdown-menu'>
                <?php
                echo "<li><a href='#' data-toggle='collapse' data-target='#function_$region_id' data-parent='#details_$region_id'>functional annotations</a></li>";
                echo "<li><a href='#' data-toggle='collapse' data-target='#similarity_$region_id' data-parent='#details_$region_id'>similarity annotations</a></li>";
                ?>
            </ul>
        </div>

        <?php
        echo "<div id='details_$region_id'><div class='panel list-group' style='width:100%;'>";
        echo "<div id='function_$region_id' class='sublinks collapse' style='width:100%;'>";
        echo "<table style='table-layout: fixed;font-size:10px;width:100%'>";
        echo "<thead><tr><td onclick=\"sortTable('table_fa_$region_id',0,1)\" style='cursor: pointer;width:15%;font-size:10px;'>algorithm name<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-alphabet' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_fa_$region_id',1,1)\" style='cursor: pointer;width:25%;font-size:10px;'>annotation name<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-alphabet' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_fa_$region_id',2,1)\" style='cursor: pointer;width:10%;font-size:10px;text-align:center;'>begin<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-order' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_fa_$region_id',3,1)\" style='cursor: pointer;width:10%;font-size:10px;text-align:center;'>end<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-order' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_fa_$region_id',4,1)\" style='cursor: pointer;width:40%;font-size:10px;text-align:center;'>description<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-alphabet' aria-hidden='true'></td></tr></thead>";
        $request = "SELECT algorithm, name, begin, end, description FROM annotation WHERE region_id='$region_id' AND algorithm!='BLASTN' AND algorithm!='BLASTP' ORDER BY algorithm, begin";
        $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
        echo "<tbody id='table_fa_$region_id'>";
        while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
            echo "<tr><td>" . $row ['algorithm'] . "</td>";
            echo "<td>" . $row ['name'] . "</td>";
            echo "<td style='text-align:right'>" . number_format($row ['begin'] + 1, 0, '.', ',') . "</td>";
            echo "<td style='text-align:right'>" . number_format($row ['end'] + 1, 0, '.', ',') . "</td>";
            echo "<td style='line-height: 15px;'>" . str_replace('|', ' ', $row ['description']) . "</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "<div id='similarity_$region_id' class='sublinks collapse' style='width:100%;'>";
        echo "<table style='table-layout: fixed;width:100%;font-size:10px;'>";
        echo "<thead><tr><td onclick=\"sortTable('table_$region_id',0,1)\" style='cursor: pointer;width:5%;font-size:10px;'>algorithm name<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-alphabet' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_$region_id',1,1)\" style='cursor: pointer;width:20%;font-size:10px;'>annotation name<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-alphabet' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_$region_id',2,1)\" style='cursor: pointer;width:6%;font-size:10px;text-align:center;'>begin<br><span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-order' aria-hidden='true'></span></td>";
        echo "<td onclick=\"sortTable('table_$region_id',3,1)\" style='cursor: pointer;width:6%;font-size:10px;text-align:center;'>end<br><span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-order' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_$region_id',4,1)\" style='cursor: pointer;width:6%;font-size:10px;'>identity<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-order' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_$region_id',5,1)\" style='cursor: pointer;width:5%;font-size:10px;'>query cover<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-order' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_$region_id',6,1)\" style='cursor: pointer;width:5%;font-size:10px;'>subject cover<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-order' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_$region_id',7,1)\" style='cursor: pointer;width:5%;font-size:10px;'>bitscore<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-order' aria-hidden='true'></td>";
        echo "<td onclick=\"sortTable('table_$region_id',8,1)\" style='cursor: pointer;width:30%;font-size:10px;'>description<span style='font-size:16px;float:right;' class='glyphicon glyphicon-sort-by-alphabet' aria-hidden='true'></td></tr></thead>";
        $request = "SELECT algorithm, name, begin, end, description FROM annotation WHERE region_id='$region_id' AND (algorithm='BLASTN' OR algorithm='BLASTP') ORDER BY algorithm, begin";
        $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
        echo "<tbody id='table_$region_id'>";
        while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
            $annot_description = $row ['description'];
            $identity = substr($annot_description, strpos($annot_description, "identity:") + 9, 5);
            $query_cover = substr($annot_description, strpos($annot_description, "query_cover:") + 12, 5);
            $subject_cover = substr($annot_description, strpos($annot_description, "subject_cover:") + 14, 5);
            $bitscore = substr($annot_description, strpos($annot_description, "bitscore:") + 9, 4);
            $annot_description = substr($annot_description, 0, strpos($annot_description, "identity:"));
            $identity = rtrim($identity, ",.");
            $query_cover = rtrim($query_cover, ",.");
            $subject_cover = rtrim($subject_cover, ",.");
            $bitscore = rtrim($bitscore, ",.");
            strrpos($annot_description, "bitscore:");
            echo "<tr><td>" . $row ['algorithm'] . "</td>";
            echo "<td>" . $row ['name'] . "</td>";
            echo "<td style='text-align:right'>" . number_format($row ['begin'] + 1, 0, '.', ',') . "</td>";
            echo "<td style='text-align:right'>" . number_format($row ['end'] + 1, 0, '.', ',') . "</td>";
            echo "<td style='text-align:right'>$identity</td>";
            echo "<td style='text-align:right'>$query_cover</td>";
            echo "<td style='text-align:right'>$subject_cover</td>";
            echo "<td style='text-align:right'>" . number_format($bitscore, 0, '.', ',') . "</td>";
            echo "<td style='line-height: 15px;'>$annot_description</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<script>";
        echo "$(document).ready(function(){";
        echo "	$(\"#details_toggle_" . $region_id . "\").click(function(){";
        echo "		$('#details_" . $region_id . "').css({ width : 100+'%' });";
        echo "	});";
        echo "});";
        echo "</script>";
        echo "</div>";
        echo "</div>";
        ?>

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>

        <?php
        if (isset($_GET['viewer'])) {
            echo "<canvas id='canvas' width='0' height='0' style='display: none;'></canvas>";
            echo "</div></div></body></html>";
        }
        ?>
