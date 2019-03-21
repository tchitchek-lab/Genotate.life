<?php

    $request_nbregions = "SELECT region.region_id FROM region JOIN transcript ON (region.transcript_id = transcript.transcript_id) JOIN analysis ON (region.analysis_id = analysis.analysis_id) ";
    $request_nbregions .= $filters_request;

    $request_nbtranscript = "SELECT DISTINCT(transcript.transcript_id) as transcript_id FROM region JOIN transcript ON (region.transcript_id = transcript.transcript_id) JOIN analysis ON (region.analysis_id = analysis.analysis_id) ";
    $request_nbtranscript .= $filters_request;

    $request_nbannotations = "SELECT annotation_id FROM annotation JOIN region ON (annotation.region_id = region.region_id) JOIN transcript ON (region.transcript_id = transcript.transcript_id) JOIN analysis ON (region.analysis_id = analysis.analysis_id) ";
    $request_nbannotations .= $filters_request;

    $results = mysqli_query($connexion, $request_nbtranscript) or die("SQL Error:<br>" . $request_nbtranscript . "<br>" . mysqli_error($connexion));
    $nb_transcripts = mysqli_num_rows($results);
    $nb_transcripts = number_format($nb_transcripts, 0, '.', ',');

    $request_nbregion_noncoding = "$request_nbregions AND coding='noncoding'";
    $results = mysqli_query($connexion, $request_nbregion_noncoding) or die("SQL Error:<br>" . $request_nbregion_noncoding . "<br>" . mysqli_error($connexion));
    $nb_regions_noncoding = mysqli_num_rows($results);
    $nb_regions_noncoding = number_format($nb_regions_noncoding, 0, '.', ',');
    $all_region = "";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $all_region .= $row['region_id'] . ",";
    }
    $all_region = rtrim($all_region, ",");
    $all_region_noncoding = serialize($all_region);

    $request_nbregion_coding = "$request_nbregions AND coding='coding'";
    $results = mysqli_query($connexion, $request_nbregion_coding) or die("SQL Error:<br>" . $request_nbregion_coding . "<br>" . mysqli_error($connexion));
    $nb_regions_coding = mysqli_num_rows($results);
    $nb_regions_coding = number_format($nb_regions_coding, 0, '.', ',');
    $all_region = "";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $all_region .= $row['region_id'] . ",";
    }
    $all_region = rtrim($all_region, ",");
    $all_region_coding = serialize($all_region);

    $request_nbregion_inner = "$request_nbregions AND type='inner'";
    $results = mysqli_query($connexion, $request_nbregion_inner) or die("SQL Error:<br>" . $request_nbregion_inner . "<br>" . mysqli_error($connexion));
    $nb_regions_inner = mysqli_num_rows($results);
    $nb_regions_inner = number_format($nb_regions_inner, 0, '.', ',');
    $all_region = "";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $all_region .= $row['region_id'] . ",";
    }
    $all_region = rtrim($all_region, ",");
    $all_region_inner = serialize($all_region);

    $request_nbregion_outside = "$request_nbregions AND type='outside'";
    $results = mysqli_query($connexion, $request_nbregion_outside) or die("SQL Error:<br>" . $request_nbregion_outside . "<br>" . mysqli_error($connexion));
    $nb_regions_outside = mysqli_num_rows($results);
    $nb_regions_outside = number_format($nb_regions_outside, 0, '.', ',');
    $all_region = "";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $all_region .= $row['region_id'] . ",";
    }
    $all_region = rtrim($all_region, ",");
    $all_region_outside = serialize($all_region);

    $results = mysqli_query($connexion, $request_nbannotations) or die("SQL Error:<br>" . $request_nbannotations . "<br>" . mysqli_error($connexion));
    $nb_annotations = mysqli_num_rows($results);
    $nb_annotations = number_format($nb_annotations, 0, '.', ',');

    $results = mysqli_query($connexion, $current_request) or die("SQL Error:<br>" . $current_request . "<br>" . mysqli_error($connexion));
    $nb_regions = mysqli_num_rows($results);
    $nb_regions_formatted = number_format($nb_regions, 0, '.', ',');
    $all_region = "";
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $all_region .= $row['region_id'] . ",";
    }
    $all_region = rtrim($all_region, ",");
    $all_region = serialize($all_region);

    echo "<form name='annotations' id='annotations' action='/includes/download_sequences.php?type=annotation' method='post' target=\"_blank\">";
    echo "<input type='hidden' name='all_region' value=$all_region></form>";

    echo "<form name='proteins' id='proteins' action='/includes/download_sequences.php?type=protein' method='post' target=\"_blank\">";
    echo "<input type='hidden' name='all_region' value=$all_region></form>";

    echo "<form name='regions' id='regions' action='/includes/download_sequences.php?type=region' method='post' target=\"_blank\">";
    echo "<input type='hidden' name='all_region' value=$all_region></form>";

    echo "<form name='regions_noncoding' id='regions_noncoding' action='/includes/download_sequences.php?type=region' method='post' target=\"_blank\">";
    echo "<input type='hidden' name='all_region' value=$all_region_noncoding></form>";

    echo "<form name='regions_coding' id='regions_coding' action='/includes/download_sequences.php?type=region' method='post' target=\"_blank\">";
    echo "<input type='hidden' name='all_region' value=$all_region_coding></form>";

    echo "<form name='regions_inner' id='regions_inner' action='/includes/download_sequences.php?type=region' method='post' target=\"_blank\">";
    echo "<input type='hidden' name='all_region' value=$all_region_inner></form>";

    echo "<form name='regions_outside' id='regions_outside' action='/includes/download_sequences.php?type=region' method='post' target=\"_blank\">";
    echo "<input type='hidden' name='all_region' value=$all_region_outside></form>";

    echo "<form name='transcripts' id='transcripts' action='/includes/download_sequences.php?type=transcript' method='post' target=\"_blank\">";
    echo "<input type='hidden' name='all_region' value=$all_region></form>";
?>


<div class="div-border-title">
    Analysis summary
    <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top"
       href="/index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['identified_elements']; ?>">
        <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style='width:100%;'>
    <table style='width:100%;'>
        <thead>
        <tr>
            <td>
                type
            </td>
            <td style='text-align: center;'>
                number of elements
            </td>
            <td style='text-align: center;'>
                download
            </td>
        </tr>
        </thead>
        <tr>
            <td>transcripts classified as non-coding</td>
            <td style='text-align:right;'><?php echo $nb_regions_noncoding; ?></td>
            <?php if ($nb_regions_noncoding > 0) { ?>
                <td style='padding:0'>
                    <button type="submit" form='regions_noncoding' class="btn btn-default" style="width:100%;height:30px;">
					<span style='font-size: 1.5em;' class='glyphicon glyphicon-download'aria-hidden='true'></span></button>
                </td>
            <?php } else {
                echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";
            } //END IF?>
        </tr>
        <tr>
            <td>transcripts classified as coding</td>
            <td style='text-align:right;'><?php echo $nb_transcripts; ?></td>
            <?php if ($nb_transcripts > 0) { ?>
                <td style='padding:0'>
                    <button type='submit' form='transcripts' class='btn btn-default' style='width:100%;height:30px;'>
					<span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button>
                </td>
            <?php } else {
                echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";
            } //END IF?>
        </tr>
        <tr>
            <td>detected ORFs</td>
            <td style='text-align:right;'><?php echo $nb_regions_coding; ?></td>
            <?php if ($nb_regions_coding > 0) { ?>
                <td style='padding:0'>
                    <button type="submit" form='regions_coding' class="btn btn-default"  style="width:100%;height:30px;">
					<span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button>
                </td>
            <?php } else {
                echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";
            } //END IF?>
        </tr>
        <tr>
            <td>translated proteins</td>
            <td style='text-align:right;'><?php echo $nb_regions_coding; ?></td>
            <?php if ($nb_regions_coding > 0) { ?>
                <td style='padding:0'>
                    <button type="submit" form='proteins' class="btn btn-default" style="width:100%;height:30px;">
                    <span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button>
                </td>
            <?php } else {
                echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";
            } //END IF?>
        </tr>
        <tr>
            <td>identifed annotations</td>
            <td style='text-align:right;'><?php echo $nb_annotations; ?></td>
            <?php if ($nb_annotations > 0) { ?>
                <td style='padding:0'>
                    <button type="submit" form='annotations' class="btn btn-default" style="width:100%;height:30px;">
					<span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button>
                </td>
            <?php } else {
                echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";
            } ?>
        </tr>
    </table>
</div>