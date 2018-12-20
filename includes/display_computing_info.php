<?php

function get_nb_annotations($row, $connexion)
{
    $request_nb_annot = "SELECT count(*) FROM annotation WHERE analysis_id=" . $row ['analysis_id'];
    $query_nb_annot = mysqli_query($connexion, $request_nb_annot) or die ("SQL Error:<br>$request_nb_annot<br>" . mysqli_error($connexion));
    $result_nb_annot = mysqli_fetch_array($query_nb_annot) or die ("SQL Error:<br>$request_nb_annot<br>" . mysqli_error($connexion));
    $result_nb_annot = number_format($result_nb_annot [0], 0, '.', ',');
    return $result_nb_annot;
}

function get_nb_region($row, $connexion)
{
    $request_nb_region = "SELECT count(*) FROM region WHERE analysis_id=" . $row ['analysis_id'];
    $query_nb_region = mysqli_query($connexion, $request_nb_region) or die ("SQL Error:<br>$request_nb_region<br>" . mysqli_error($connexion));
    $result_nb_region = mysqli_fetch_array($query_nb_region) or die ("SQL Error:<br>$request_nb_region<br>" . mysqli_error($connexion));
    if ($row ['status'] == "computing") {
        $result_nb_region = number_format($row ['nb_transcripts'], 0, '.', ',');
    } else {
        $result_nb_region = number_format($result_nb_region [0], 0, '.', ',');
    }
    return $result_nb_region;
}

function get_nb_transcript($row, $connexion)
{
    $request_nb_transcript = "SELECT count(*) FROM transcript WHERE analysis_id=" . $row ['analysis_id'];
    $query_nb_transcript = mysqli_query($connexion, $request_nb_transcript) or die ("SQL Error:<br>$request_nb_transcript<br>" . mysqli_error($connexion));
    $result_nb_transcript = mysqli_fetch_array($query_nb_transcript) or die ("SQL Error:<br>$request_nb_transcript<br>" . mysqli_error($connexion));
    $result_nb_transcript = number_format($result_nb_transcript [0], 0, '.', ',');
    return $result_nb_transcript;
}

function datasets_info($row, $connexion, $database_id,$tooltip_text)
{

    include($_SERVER['DOCUMENT_ROOT'] . "/includes/tooltips.php");

    ?>


<div style="width: 100%;"><label type=title>Annotation results</label></div>

<?php  
$state = $row ['status'];
if ($state == "computing") {
?>
    <p style='text-align: justify;text-justify: inter-word;'>
        Please wait during the analysis of your dataset. You can see below the analysis parameters used for your dataset.

    <div class="div-border-title" style="width: 100%;">
        Analysis status
    </div>
    <div class="div-border" style="width: 100%;margin-bottom:10px;padding:5px;">
        <div style="width: 100%;">
            <label for='db_name'>transcripts being analyzed</label>
            <input readonly type="text" title="nb_transcripts" value="<?php echo number_format($row['nb_transcripts'], 0, '.', ','); ?>"
                   style="width: 100%; height: 2em; text-align: right;background-color:rgba(229,229,229, 0.2);">
        </div>
        <label>analysis progress</label>

        <?php
        $file_base = $_SERVER['DOCUMENT_ROOT'] . "../tmp/" . $database_id . "/temporary/";
        $progress = 0 ;
        if(file_exists($file_base)){$progress = get_percentage($file_base);}

        echo "<div class='progress' style='padding:0;height:30px;width: 100%;margin: 0 0 5px;border:1px solid grey'>";
        echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: $progress%;' aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100'>" . number_format($progress, 2, '.', ', ') . "%</div>";
        echo "</div>";
        if ($progress > 0) {
            $startTime = strtotime($row['creation_date']);
            $current = $progress;
            $percentleft = 100 - $progress;
            $timeTaken = microtime(true) - $startTime;

            $days = floor($timeTaken / (60 * 60 * 24));
            $hours = floor($timeTaken / (60 * 60)) - ($days * 24);
            $minutes = floor($timeTaken / (60)) - ($days * 24 * 60) - ($hours * 60);
            $seconds = floor($timeTaken) - ($days * 24 * 60 * 60) - ($hours * 60 * 60) - ($minutes * 60);
            $time_spend = "{$days}d {$hours}h {$minutes}m {$seconds}s";

            $timeLeft = ($timeTaken / $current) * $percentleft;
            $days = floor($timeLeft / (60 * 60 * 24));
            $hours = floor($timeLeft / (60 * 60)) - ($days * 24);
            $minutes = floor($timeLeft / (60)) - ($days * 24 * 60) - ($hours * 60);
            $seconds = floor($timeLeft) - ($days * 24 * 60 * 60) - ($hours * 60 * 60) - ($minutes * 60);
            $time_left = "{$days}d {$hours}h {$minutes}m {$seconds}s";
        } else {
            $time_left = "";
            $time_spend = "";
        }
        ?>
        <div style="width: 100%;">
            <label for='db_name'>time spent</label>
            <input readonly type="text" title="time_spend" value="<?php echo $time_spend; ?>"
                   style="width: 100%; height: 2em; text-align: right;background-color:rgba(229,229,229, 0.2);">
        </div>
        <div style="width: 100%;">
            <label for='db_name'>estimated remaining time</label>
            <input readonly type="text" title="db_name" value="<?php echo $time_left; ?>"
                   style="width: 100%; height: 2em; text-align: right;background-color:rgba(229,229,229, 0.2);">
        </div>
        <div style="width: 100%;">
            <label style="float:right;margin-top:10px;">next page refresh in <span id="countdown" style="margin:2px;">10</span>s</label>
            <meta http-equiv="refresh" content="10">
            <script type="text/javascript">
                function timeout() {
                    setTimeout(function () {
                        var seconds = $('#countdown').html();
                        seconds = parseInt(seconds, 10);
                        seconds = seconds - 1;
                        $('#countdown').html(seconds);
                        timeout();
                    }, 1000);
                }

                timeout();
            </script>
        </div>
    </div>

<?php
}
?>

    <script>
        function copytextfunctional() {
            let text = document.getElementById('textarea_functional').value;
            prompt("Copy to clipboard: Ctrl+C, Enter", text);
        }

        function copytextsimilarity() {
            let text = document.getElementById('textarea_similarity').value;
            prompt("Copy to clipboard: Ctrl+C, Enter", text);
        }
    </script>

    <div style='width: 50%; padding: 0; margin: 0; padding-right: 5px; padding-bottom: 5px; height: 270px;'>
        <div class="div-border-title">
            Dataset information
            <a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top"
               href="/index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['dataset_filter']; ?>">
                <img src="/img/tutorial.svg"
                     style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
        </div>
        <div class="div-border" style="padding: 5px; height: 230px">
            <div style="width: 100%;">
                <label for='db_name'>analysis name</label>
                <input readonly type="text" id="name" name="name" value="<?php echo $row['name']; ?>"
                       style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
            </div>
            <div style="width: 100%;">
                <label for='db_name'>description</label>
                <input readonly type="text" id="name" name="name" value="<?php echo $row['description']; ?>"
                       style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
            </div>

            <?php
            $result_nb_transcript = get_nb_transcript($row, $connexion);

            $result_nb_region = get_nb_region($row, $connexion);

            $result_nb_annot = get_nb_annotations($row, $connexion);
            ?>

            <div style="width: 50%; padding-right: 5px;">
                <label for='db_name'>processed transcripts</label>
                <input readonly type="text" value="<?php echo $result_nb_transcript; ?>"
                       style="width: 100%; height: 2em; text-align: right;background-color:rgba(229,229,229, 0.2);">
            </div>
            <div style="width: 50%;">
                <label>detected ORFs</label>
                <input readonly type="text" value="<?php echo $result_nb_region; ?>"
                       style="width: 100%; height: 2em; text-align: right;background-color:rgba(229,229,229, 0.2);">
            </div>
            <div style="width: 50%; padding-right: 5px;">
                <label>identified annotations</label>
                <input readonly type="text" value="<?php echo $result_nb_annot; ?>"
                       style="width: 100%; height: 2em; text-align: right;background-color:rgba(229,229,229, 0.2);">
            </div>
            <div style="width: 50%;">
                <label>creation date</label>
                <input readonly type="text" value="<?php echo $row['creation_date']; ?>"
                       style="width: 100%; height: 2em; text-align: center;background-color:rgba(229,229,229, 0.2);">
            </div>
        </div>
    </div>

    <div style='width: 50%; padding: 0; margin: 0; padding-bottom: 5px; height: 270px;'>
        <div class="div-border-title">
            ORF identification parameters<a style='float: right; margin-right: 10px;' data-toggle="tooltip"
                                            data-placement="top" href="/index.php?page=tutorial" target="_blank"
                                            title="<?php echo $tooltip_text['orf_panel']; ?>"> <img
                        src="/img/tutorial.svg" style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
        </div>
        <div class="div-border" style="padding: 5px; height: 230px">
            <div style="width: 100%;">
                <label for="start_codon">start codon(s)</label>
                <input readonly type="text" value="<?php echo $row['start_codons']; ?>"
                       style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
            </div>
            <div style="width: 100%;">
                <label for="stop_codon">stop codon(s)</label>
                <input readonly type="text" value="<?php echo $row['stop_codons']; ?>"
                       style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
            </div>
            <div class="input-group" style="padding: 0; margin: 0; margin-top: 5px; width: 100%; height: 30px;">
                <span class='input-group-btn' style="width: 66.6%; height: 30px;"><label
                            style="width: 100%; height: 30px;"
                            class="btn btn-default <?php if (intval($row['min_orf_size']) > 0) {
                                echo "active";
                            } ?>" type="button" for='orf_min_size'>minimal ORF length</label></span>
                <input readonly class="form-control" type="number" value="<?php echo $row['min_orf_size']; ?>"
                       style="height: 30px; text-align: right;">
                <span class='input-group-addon' style='padding-top: 0; padding-bottom: 0;'>bases</span>
            </div>
            <div class="btn-group" style="width: 100%; padding: 0; margin: 0; margin-top: 5px;">
                <label data-toggle='buttons' style='width: 50%;' class='btn btn-default <?php if ($row['inner_orf']) {
                    echo "active";
                } ?>'> compute inner ORFs </label>
                <label data-toggle='buttons' style='width: 50%;' class='btn btn-default <?php if ($row['outside_orf']) {
                    echo "active";
                } ?>'> compute outside ORFs </label>
            </div>
            <div class="btn-group" style="width: 100%; padding: 0; margin: 0; margin-top: 5px; margin-bottom: 5px;">
                <label data-toggle='buttons' style='width: 50%;'
                       class='btn btn-default <?php if ($row['compute_ncrna']) {
                           echo "active";
                       } ?>'> compute ncRNA</label>
                <label data-toggle='buttons' style='width: 50%;'
                       class='btn btn-default <?php if ($row['compute_reverse']) {
                           echo "active";
                       } ?>'> compute both strands</label>
            </div>
        </div>
    </div>
    <div style='width: 50%; margin: 0; padding: 0 5px 5px 0;height: 250px;'>
        <div class="div-border-title">
            Homology annotation parameters <a style='float: right; margin-right: 10px;' data-toggle="tooltip"
                                              data-placement="top" href="/index.php?page=tutorial" target="_blank"
                                              title="<?php echo $tooltip_text['similarity_panel']; ?>"> <img
                        src="/img/tutorial.svg"
                        style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
            <button onclick='copytextsimilarity();'
                    style="float: right; margin-right: 5px; width: 30px; height: 30px; padding: 5px;"
                    data-toggle="tooltip" data-placement="top" title="" class="btn btn-md btn-primary"
                    data-original-title="copy similarity annotation references">
                <span class="glyphicon glyphicon-copy" aria-hidden="true"></span>
            </button>
        </div>
        <div class="div-border" style='padding: 5px; height: 210px; width: 100%; overflow: auto; overflow-y: scroll;'>
            <?php
            $services_array = explode("],", $row ['services']);
            $i = 0;
            foreach ($services_array as $service) {
                if (substr_count($service, "BLASTN") > 0 || substr_count($service, "BLASTP") > 0) {
                    $key = explode("[", $service) [0];
                    $value = explode("[", $service) [1];
                    $name = explode(",", $value) [0];
                    $identity = explode(",", $value) [1];
                    $qc = explode(",", $value) [2];
                    $sc = explode(",", $value) [3];
                    $sc = rtrim($sc, "]");
                    $i++;
                    ?>

                    <div style="padding: 0; margin: 0; margin-top: 5px; width: 100%;">
                        <div class='btn-group' role='group' style='align: left; width: 100%;'>
                            <label style="width: 90%; height: 20px;" class="btn btn-sm btn-default active"
                                   type="button"><?php echo $name; ?></label>
                            <button style='width: 10%; height: 20px;' class='btn btn-default' type='button'
                                    data-toggle='collapse' data-target='#collapse_<?php echo $i; ?>'
                                    aria-expanded='false' aria-controls='collapse_<?php echo $i; ?>'>
                                <span class='caret' style='height: 20px;'></span>
                            </button>
                            <div class='collapse' id='collapse_<?php echo $i; ?>' style='width: 100%;'>
                                <div class='card card-block' style='width: 100%;'>
                                    <div class='input-group' style='width: 100%;'>
                                        <span class='input-group-addon'
                                              style='width: 70%; padding-top: 0; padding-bottom: 0;'>identity percentage</span>
                                        <input readonly class="form-control" type="number"
                                               value="<?php echo $identity; ?>"
                                               style="width: 100%; height: 20px; text-align: right;">
                                    </div>
                                    <div class='input-group' style='width: 100%;'>
                                        <span class='input-group-addon'
                                              style='width: 70%; padding-top: 0; padding-bottom: 0;'>query alignment coverage</span>
                                        <input readonly class="form-control" type="number" value="<?php echo $qc; ?>"
                                               style="width: 100%; height: 20px; text-align: right;">
                                    </div>
                                    <div class='input-group' style='width: 100%;'>
                                        <span class='input-group-addon'
                                              style='width: 70%; padding-top: 0; padding-bottom: 0;'>subject alignment coverage</span>
                                        <input readonly class="form-control" type="number" value="<?php echo $sc; ?>"
                                               style="width: 100%; height: 20px; text-align: right;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <div style='width: 50%; margin: 0; padding: 0 0 5px;height: 250px;'>
        <div class="div-border-title">
            Functionnal annotation parameters <a style='float: right; margin-right: 10px;' data-toggle="tooltip"
                                                 data-placement="top" href="/index.php?page=tutorial" target="_blank"
                                                 title="<?php echo $tooltip_text['functional_panel']; ?>"> <img
                        src="/img/tutorial.svg"
                        style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
            <button onclick='copytextfunctional();'
                    style="float: right; margin-right: 5px; width: 30px; height: 30px; padding: 5px;"
                    data-toggle="tooltip" data-placement="top" title="" class="btn btn-md btn-primary"
                    data-original-title="copy functional annotation services">
                <span class="glyphicon glyphicon-copy" aria-hidden="true"></span>
            </button>
        </div>
        <div class="div-border" style='padding: 5px; height: 210px; width: 100%; overflow: auto; overflow-y: scroll;'>
            <?php
            $services_array = explode("],", $row ['services']);
            foreach ($services_array as $service) {
                if ($service != "" && substr_count($service, "BLASTN") == 0 && substr_count($service, "BLASTP") == 0) {
                    $key = explode("[", $service) [0];
                    $value = explode("[", $service) [1];
                    $value = rtrim($value, "]");
                    ?>
                    <div class="input-group" style="padding: 0; margin: 0; margin-top: 5px; width: 100%; height: 20px;">
                        <span class="input-group-btn" style="width: 66.6%; height: 20px;"> <label
                                    style="width: 100%; height: 20px;" class="btn btn-sm btn-default active"
                                    type="button"><?php echo $key; ?></label></span>
                        <input readonly class="form-control" type="number" value="<?php echo $value; ?>"
                               style="height: 20px; text-align: right;">
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
    // COPY PASTE AREAS
    $text = "";
    $services_array = explode("],", $row ['services']);
    foreach ($services_array as $service) {
        if ($service != "" && substr_count($service, "BLASTN") == 0 && substr_count($service, "BLASTP") == 0) {
            $service = rtrim($service, "]");
            $text .= "$service], ";
        }
    }
    echo "<input id='textarea_functional' type='hidden' value='$text'>";
    $text = "";
    $services_array = explode("],", $row ['services']);
    foreach ($services_array as $service) {
        if (substr_count($service, "BLASTN") > 0 || substr_count($service, "BLASTP") > 0) {
            $key = explode("[", $service) [0];
            $value = explode("[", $service) [1];
            $name = explode(",", $value) [0];
            $identity = explode(",", $value) [1];
            $qc = explode(",", $value) [2];
            $sc = explode(",", $value) [3];
            $sc = rtrim($sc, "]");
            $service = ($name . " identity=" . $identity . ";query_cover=" . $qc . ";subject_cover=" . $sc);
            $text .= "$service, ";
        }
    }
    echo "<input id='textarea_similarity' type='hidden' value='$text'>";

}

function get_percentage($file_base)
{
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
    return $progress;
}


?>
