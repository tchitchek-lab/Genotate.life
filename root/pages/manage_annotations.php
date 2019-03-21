<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/config_file.php");
?>

<script src="/root/js/manage_annotations.js?v=618546156" xmlns:right></script>

<?php
$disabled_status = "";
if (USER_MODE == "restricted") {
    $disabled_status = "disabled";
}
?>

<label type=title>Manage annotation results</label>
<p style='text-align: justify;text-justify: inter-word;'>
    Genotate management interface lists the annotated transcripts query with their computation current status,
    information, results, and the possibility to rename or delete them. For each query, the transcripts sequences, the
    ORFs sequences, and the annotations can be downloaded. The details can be displayed with the ORFs detection
    parameters, the tools used for the functional annotations, and the databases used for the homology annotations.
</p>
<p style='text-align: justify;text-justify: inter-word;'>
Annotation results are keep during 48 hours.
</p>
<br>

<div class="div-border-title">
    Annotation results
    <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top"
       href="/index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['manage_annotations']; ?>">
        <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border">
    <form name='datasetform' id='datasetform' action='' method='post'></form>

    <table class='manage_tables' style='width: 100%;'>
        <thead>
        <tr>
            <td>dataset name</td>
            <td style='text-align:center;'>creation date</td>
            <td style='width:10%;text-align:center;'>number of transcripts</td>
            <td style='width:215px;text-align:center;'>possible actions</td>
            <td style='width:10%;text-align:center;'>status</td>
        </tr>
        </thead>

        <?php

        $request = "SELECT * FROM analysis ORDER BY creation_date DESC";
        $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
        while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $analysis_id = $row ['analysis_id'];
        $encoded_id = $row ['encoded_id'];
        $file_name = "transcripts.fasta";
        echo "<form name='transcript_$analysis_id' id='transcript_$analysis_id' action='/root/includes/download_files.php' method='post' target=\"_blank\">";
        echo "<input type='hidden' name='analysis_id' value='/$analysis_id/$file_name'>";
        echo "<input type='hidden' name='type' value='annotation'></form>";
        $file_name = "regions_nucl.fasta";
        echo "<form name='region_$analysis_id' id='region_$analysis_id' action='/root/includes/download_files.php' method='post' target=\"_blank\">";
        echo "<input type='hidden' name='analysis_id' value='/$analysis_id/$file_name'>";
        echo "<input type='hidden' name='type' value='annotation'></form>";
        $file_name = "regions_prot.fasta";
        echo "<form name='protein_$analysis_id' id='protein_$analysis_id' action='/root/includes/download_files.php' method='post' target=\"_blank\">";
        echo "<input type='hidden' name='analysis_id' value='/$analysis_id/$file_name'>";
        echo "<input type='hidden' name='type' value='annotation'></form>";
        $file_name = "all_annotations.txt";
        echo "<form name='annotation_$analysis_id' id='annotation_$analysis_id' action='/root/includes/download_files.php' method='post' target=\"_blank\">";
        echo "<input type='hidden' name='analysis_id' value='/$analysis_id/$file_name'>";
        echo "<input type='hidden' name='type' value='annotation'></form>";
        echo "<tr>";
        echo "<td style='word-break: break-all;'>{$row['name']}</td>";
        echo "<td style='text-align:center;'>{$row['creation_date']}</td>";
        $result_nb_transcript = number_format($row['nb_transcripts'], 0, '.', ',');
        echo "<td style='text-align:right;'>$result_nb_transcript</td>";

        echo "<td>";
        echo "<a href='/root/index.php?page=manage_annotation_details&encoded_id=$encoded_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='".$tooltip_text['manage_getinfo']."' class='btn btn-md btn-primary'>";
        echo "<span class='glyphicon glyphicon-question-sign' aria-hidden='true'></span></button></a>";

        if ($row ['status'] != "computing") {
            echo "<a href='/root/index.php?page=view_annotations&encoded_id=$encoded_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='view annotation results' class='btn btn-md btn-primary' >";
            echo "<span class='glyphicon glyphicon-th-list' aria-hidden='true'></span></button></a>";
        }else{
            echo "<a href='/root/index.php?page=view_annotations&encoded_id=$encoded_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='view annotation results' class='btn btn-md btn-primary' disabled>";
            echo "<span class='glyphicon glyphicon-th-list' aria-hidden='true'></span></button></a>";
        }
        if ($row ['status'] != "computing") {
            echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='rename dataset' class='btn btn-md btn-primary' onclick='rename_annotation_dataset($analysis_id)' $disabled_status><span class='glyphicon glyphicon-pencil'></span></button>";
        }else{
            echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='rename dataset' class='btn btn-md btn-primary' onclick='rename_annotation_dataset($analysis_id)' disabled><span class='glyphicon glyphicon-pencil'></span></button>";
        }
        if ($row ['status'] != "computing") {
            echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='delete dataset' class='btn btn-md btn-danger'  onclick='delete_annotation_dataset($analysis_id)' $disabled_status><span class='glyphicon glyphicon-remove'></span></button>";
        } else {
            echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='interrupt dataset' class='btn btn-md btn-danger' onclick='interrupt_annotation_dataset($analysis_id)' $disabled_status><span class='glyphicon glyphicon-off'></span></button>";
        }

        ?>
        <div class="dropdown" style='width: 85px;'>
            <?php
            if ($row ['status'] != "computing") {
                echo "<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' style='width:85px;' >download<span class='caret' style='margin-left:5px;'></span></button>";
            } else {
                echo "<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' style='width:85px;' disabled>download<span class='caret' style='margin-left:5px;'></span></button>";
            }
            ?>
            <ul class="dropdown-menu">
                <?php
                echo "<li><a href=\"javascript:document.getElementById('transcript_$analysis_id').submit();\">transcripts</a></li>";
                echo "<li><a href=\"javascript:document.getElementById('region_$analysis_id').submit();\">regions</a></li>";
                echo "<li><a href=\"javascript:document.getElementById('protein_$analysis_id').submit();\">proteins</a></li>";
                $request_nb_annot = "SELECT count(*) FROM annotation WHERE analysis_id=" . $analysis_id;
                $query_nb_annot = mysqli_query($connexion, $request_nb_annot) or die ("SQL Error:<br>$request_nb_annot<br>" . mysqli_error($connexion));
                $result_nb_annot = mysqli_fetch_array($query_nb_annot) or die ("SQL Error:<br>$request_nb_annot<br>" . mysqli_error($connexion));
                if ($result_nb_annot [0] > 0) {
                    echo "<li><a href=\"javascript:document.getElementById('annotation_$analysis_id').submit();\">annotations</a></li>";
                }
                ?>
            </ul>
        </div>

        <?php
        echo "</td>";
        ?>
        <td style='text-align:right;'>
            <?php
            if ($row['status'] == "complete") {
                echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
                echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: 100%;' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>";
                echo "</div>";
            } else {
                $file_base = $_SERVER['DOCUMENT_ROOT'] . "../tmp/" . $analysis_id . "/temporary/";
                if(file_exists($file_base)){
                    $folders = scandir($file_base);
                    array_shift($folders);
                    array_shift($folders);
                    $table = array();
                    sort($folders);
                    foreach ($folders as $folder) {
                        $files = scandir($file_base . $folder . "/");
                        array_shift($files);
                        array_shift($files);
                        //echo '<pre>'; print_r($files); echo '</pre>';
                        foreach ($files as $file) {
                            if (preg_match('/^(\d+\_[A-Z]+)\_.+$/', $file, $matches)) {
                                $service = $matches[1];
                                if (strpos($file, "complete.txt") !== false) {
                                    $table[$service . $folder] = "computed";
                                } else {
                                    if (!isset($table[$service . $folder])) {
                                        $table[$service . $folder] = "waiting";
                                    } else if ($table[$service . $folder] != "computed") {
                                        $table[$service . $folder] = "waiting";
                                    }
                                }
                            }
                        }
                    }
                    $counts = array_count_values($table);
                    if(isset($counts["computed"])){ $completed = $counts["computed"];}else{$completed = 0;}
                    if(isset($counts["waiting"])){ $waiting = $counts["waiting"];}else{$waiting = 0;}
                    $max = $waiting + $completed;
                    $progress=0;
                    if($max> 0){$progress = ($completed / $max) * 100;}
                  echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
                  echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: $progress%;' aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100'>" . number_format($progress, 0, '.', ', ') . "%</div>";
                  echo "</div>";
                }
            }
            }
            ?>
        </td>
    </table>

</div>

<script>
    document.title = "Genotate.life - Admin - Manage annotation results";
</script>


