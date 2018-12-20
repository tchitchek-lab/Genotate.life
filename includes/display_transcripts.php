<style>
    rect:hover {
        stroke: black;
        fill-opacity: 0.9;
    }
</style>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/tooltips.php");

$connexion = connect_database();
$analysis_id = $_POST['dataset'];

$request = "SELECT transcript_id, transcript.name AS transcript_name, transcript.description AS transcript_desc, transcript.size AS transcript_size, analysis.analysis_id, analysis.name AS dataset_name FROM transcript, analysis WHERE transcript.analysis_id = analysis.analysis_id AND analysis.analysis_id=$analysis_id";
$results = mysqli_query($connexion, $request) or die("SQL Error:<br>" . $request . "<br>" . mysqli_error($connexion));
$row = mysqli_fetch_array($results, MYSQLI_ASSOC);

$transcript_id = $row['transcript_id'];
$dataset_name = $row['dataset_name'];
$transcript_name = $row['transcript_name'];
$transcript_desc = $row['transcript_desc'];
$transcript_size = $row['transcript_size'];

?>

<div class="div-border-title">
    Overview of detected ORFs
    <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top"
       href="/index.php?page=tutorial" target="_blank"
       title="<?php echo $tooltip_text['identified_elements']; ?>">
        <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>

<?php
if ($transcript_id == "") {
    echo "<div class='div-border' style='margin:0;padding:10px;overflow:auto;width:100%;max-height:30em;'>No ORF identified</div>";
    return -1;
}

//GENERATE SVG
$svgtext = "";
$zoom_ratio = $_POST['zoom_ratio'] / $transcript_size;

$offset_x = 0;
$pos_y = 10;
$height_rect = 8;
$offset_inter_annotation = 2;
$svg_width = $zoom_ratio * $transcript_size + $offset_x - 18;
$svgtext = "\n<svg width='" . $svg_width . "' height='100%' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' >";

//CREATE SCALE
$scale_start = (1 / $zoom_ratio);
for ($scale = 1; $scale < $zoom_ratio * $transcript_size; $scale += $zoom_ratio * 1000) {
    $svgtext .= "\n<text  x='" . ($offset_x + $scale - 3) . "' ";
    $svgtext .= "y='" . ($pos_y) . "' ";
    $svgtext .= "font-family='Verdana' font-size='10'  ";
    $svgtext .= "style='fill:rgb(0,0,0)" . "' >";
    $svgtext .= "|" . number_format(($scale / $zoom_ratio) - $scale_start + 1, 0) . "";
    $svgtext .= "</text>";
}
$pos_y = $pos_y + 2;

//transcript RECTANGLE
$svgtext .= "\n<rect x='" . $offset_x . "' y='" . $pos_y . "'  width='" . $zoom_ratio * $transcript_size . "' height='" . $height_rect . "' style='stroke: black;' fill='DeepSkyBlue' fill-opacity=0.8>";
$svgtext .= "<title>transcript 1-" . $transcript_size . "</title>";
$svgtext .= "</rect>";
$pos_y = $pos_y + $offset_inter_annotation;
$plus_line = 1;
$minus_line = 1;
$request = "SELECT * FROM region WHERE transcript_id=$transcript_id ORDER BY strand, begin";
$results = mysqli_query($connexion, $request) or die("SQL Error:<br>" . $request . "<br>" . mysqli_error($connexion));
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
    $region_id = $row['region_id'];
    $begin = $row['begin'];
    $end = $row['end'];
    $size = $row['size'];
    $strand = $row['strand'];
    $type = $row['type'];
    $coding = $row['coding'];
    $begin_ratio = $zoom_ratio * $begin;
    $end_ratio = $zoom_ratio * $end;
    $length = $zoom_ratio * $size;
    $rect_x = $zoom_ratio * $begin + $offset_x;
    if ($strand == "+" && $plus_line) {
        $pos_y = $pos_y + $height_rect + $offset_inter_annotation;
        for ($pos = 0; $pos < $zoom_ratio * $transcript_size; $pos += ($zoom_ratio * $transcript_size) / 100) {
            $svgtext .= "\n<text  x='" . ($pos) . "' ";
            $svgtext .= "y='" . ($pos_y + $height_rect - 1) . "' ";
            $svgtext .= "font-family='Verdana' font-size='10'  ";
            $svgtext .= "style='fill:rgb(0,0,0)" . "' >";
            $svgtext .= ">";
            $svgtext .= "</text>";
        }
        $plus_line = 0;
    }
    if ($strand == "-" && $minus_line) {
        $pos_y = $pos_y + $height_rect + $offset_inter_annotation;
        for ($pos = 0; $pos < $zoom_ratio * $transcript_size; $pos += ($zoom_ratio * $transcript_size) / 100) {
            $svgtext .= "\n<text  x='" . ($pos) . "' ";
            $svgtext .= "y='" . ($pos_y + $height_rect - 1) . "' ";
            $svgtext .= "font-family='Verdana' font-size='10'  ";
            $svgtext .= "style='fill:rgb(0,0,0)" . "' >";
            $svgtext .= "<";
            $svgtext .= "</text>";
        }
        $minus_line = 0;
    }
    $pos_y = $pos_y + $height_rect + $offset_inter_annotation;

    //RECTANGLE OF THE REGION
    $color = "green";
    if ($strand == "+") {
        $color = "red";
    }
    $name = "" . ($begin + 1) . "-" . ($end + 1) . " $type";
    $svgtext .= "\n<rect x='" . ($rect_x) . "' y='$pos_y' width='" . ($length) . "' height='$height_rect' fill='$color' fill-opacity=0.8  onclick=\"viewer('$region_id',800,300);\">";
    $svgtext .= "<title>$name</title>";
    $svgtext .= "</rect>";

    //TEXT OF THE ANNOTATION
    if ($coding != "noncoding") {
        $name = "" . ($begin + 1) . "-" . ($end + 1) ;
    } else {
        $name = "" . ($begin + 1) . "-" . ($end + 1) . " ncRNA";
    }
    $namecut = substr($name, 0, $length / 5);
    $left_margin = 2;
    if (($length / 2 - strlen($namecut) * 3) > strlen($namecut)) {
        $left_margin = $length / 2 - strlen($name) * 3;
    }
    if ($length < 15) {
        $namecut = "";
    }
    $svgtext .= "\n<text   x='" . ($rect_x + $left_margin) . "' y='" . ($pos_y + $height_rect - 1) . "'  onclick=\"viewer('$region_id',800,300);\" ";
    $svgtext .= "font-family='Verdana' font-size='" . $height_rect . "'  style='fill:rgb(0,0,0);'>";
    $svgtext .= $namecut;
    $svgtext .= "<title>$name</title> ";
    $svgtext .= "</text>";
}


echo "<div id='svg_div_scroll_$transcript_id' class='div-border' style='margin:0;padding:0;width:100%;max-height:300px;overflow-y:scroll;'>";
$pos_y = $pos_y + $height_rect + $offset_inter_annotation;
echo "<div style='margin:1px;padding:0;overflow:hidden;width:{$svg_width}px; height:" . $pos_y . "px" . "; '>";
echo $svgtext;
echo "</div>";
echo "</div>";
