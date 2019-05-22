<?php
include($_SERVER['DOCUMENT_ROOT'] . "/includes/tooltips.php");
include($_SERVER['DOCUMENT_ROOT'] . "/includes/algorithms_info.php");
?>

<div style='width: 420px; margin: 0; padding: 0 0 5px;height: 300px;'>
    <div class="div-border-title">
        ORF identification parameters <a style='float: right; margin-right: 10px;' data-toggle="tooltip"
                                         data-placement="top" href="/index.php?page=tutorial" target="_blank"
                                         title="<?php echo $tooltip_text['orf_panel']; ?>"> <img src="/img/tutorial.svg"
                                                                                                 style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
    </div>
    <div class="div-border" style='padding: 5px; height: 260px;'>
        <div style="width: 100%;">
            <label for="start_codon">start codon(s)</label>
            <div style="float:right;">
                <button data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['code_standard']; ?>"
                        class='btn btn-sm btn-secondary' style='border:1px solid lightgrey;margin-bottom:2px;'
                        onclick="$('#start_codon').val('ATG');$('#stop_codon').val('TAG,TGA,TAA');" form=''>Standard
                </button>
                <button data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['code_vert_mito']; ?>" class='btn btn-sm btn-secondary'
                        style='border:1px solid lightgrey;margin-bottom:2px;'
                        onclick="$('#start_codon').val('ATT,ATC,ATA,ATG,GTG');$('#stop_codon').val('TAG,AGA,TAA,AGG');"
                        form=''>Vertebrate Mito.
                </button>
                <button data-toggle="tooltip" data-placement="top"
                        title="<?php echo $tooltip_text['code_invert_mito']; ?>" class='btn btn-sm btn-secondary'
                        style='border:1px solid lightgrey;margin-bottom:2px;'
                        onclick="$('#start_codon').val('ATG,ATA,TTG,ATT');$('#stop_codon').val('TAG,TAA');" form=''>
                    Invertebrate Mito.
                </button>
            </div>
            <input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['start_codon']; ?>"
                   type="text" id="start_codon" name="start_codon" value="ATG" onchange='check_start_codon()'
                   onkeyup='check_start_codon()' style="width: 100%; height: 2em; text-align: left;">
        </div>
        <div style="width: 100%;">
            <label for="stop_codon">stop codon(s)</label>
            <input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['stop_codon']; ?>"
                   type="text" id="stop_codon" name="stop_codon" value="TAG,TGA,TAA" onchange='check_stop_codon()'
                   onkeyup='check_stop_codon()' style="width: 100%; height: 2em; text-align: left;">
        </div>
        <div data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['orf_min_size']; ?>"
             style="width: 100%;">
            <div class="input-group" style="padding: 0; margin: 5px 0 0;width: 50%; height: 30px;">
                <label data-toggle='buttons' style="width: 100%; height: 30px;" class="btn btn-default active"
                       type="button" for='orf_min_size_checkbox'>
                    minimal ORF length
                    <input type="checkbox" id="checkbox_orf_min_size" name="checkbox_orf_min_size"
                           style='display: none;' checked>
                </label>
            </div>
            <div class="input-group" style="padding: 0; margin: 5px 0 0;width: 50%; height: 30px;">
                <input class="form-control" type="number" id="orf_min_size" name="orf_min_size" min="6" max="9999999"
                       value="300" style="width: 100%; height: 30px; text-align: right; float: right"
                       title="orf_min_size">
                <span class='input-group-addon' style='padding-top: 0; padding-bottom: 0; width: 75px;'>bases</span>
            </div>
        </div>
        <div data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['checkORF']; ?>" style="width: 100%;">
            <div class="input-group" style="padding: 0; margin: 5px 0 0;width: 50%; height: 30px;">
                <label data-toggle='buttons' style="width: 100%; height: 30px;" class="btn btn-default active" type="button" for='checkORF_checkbox'>
                    minimal ORF coding potential
                    <input type="checkbox" id="checkbox_checkORF" name="checkbox_checkORF" style='display: none;' checked>
                </label>
            </div>
            <div class="input-group" style="padding: 0; margin: 5px 0 0;width: 50%; height: 30px;">
                <input class="form-control" type="number" id="checkORF_threshold" name="checkORF_threshold" min="0" max="1"  step='0.01'
                       value="0.5" style="width: 100%; height: 30px; text-align: right; float: right"  title="checkORF_threshold">
                <span class='input-group-addon' style='padding-top: 0; padding-bottom: 0; width: 75px;'>percent</span>
            </div>
        </div>
        <div style="width: 100%; padding: 0; margin: 5px 0;">
			<span data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['inner']; ?>"
                  style="width: 50%; float: left;"> <label data-toggle='buttons' class='btn btn-default' for="inner_orf"
                                                           style="width: 100%;">
					<input type="checkbox" id="inner_orf" name="inner_orf" style='display: none;'>
					compute inner ORFs
				</label>
			</span> <span data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['outside']; ?>"
                          style="width: 50%; float: left;"> <label data-toggle='buttons' class='btn btn-default'
                                                                   for="outside_orf" style="width: 100%;">
					<input type="checkbox" id="outside_orf" name="outside_orf" style='display: none;'>
					compute outside ORFs
				</label>
			</span>
        </div>
        <div style="width: 100%; padding: 0; margin: 0;">
            <span data-toggle="tooltip" data-placement="top"
                          title="<?php echo $tooltip_text['compute_both_strands']; ?>" style="width: 50%; float: left;"> <label
                        data-toggle='buttons' class='btn btn-default active' for="compute_reverse" style="width: 100%;">
					<input type="checkbox" id="compute_reverse" name="compute_reverse" checked style='display: none;'>
					compute both strands
				</label>
			</span>
            <span data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['compute_ncRNA']; ?>" style="width: 50%; float: left;">
			<label data-toggle='buttons' class='btn btn-default active' for="ncRNA" style="width: 100%;" onclick="$('#container_noncoding').toggle();">
					<input type="checkbox" id="compute_ncrna" name="compute_ncrna" checked style='display: none;'>
					compute non-coding
				</label>
			</span>
        </div>
    </div>
</div>


<div style='width: 420px; margin: 0; padding: 0 5px 5px 0;height: 250px;'>
    <div class="div-border-title">
       Homology annotation parameters <a style='float: right; margin-right: 10px;' data-toggle="tooltip"
                                          data-placement="top" href="/index.php?page=tutorial" target="_blank"
                                          title="<?php echo $tooltip_text['similarity_panel']; ?>"> <img
                    src="/img/tutorial.svg"
                    style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
    </div>

    <div class="div-border" style='padding: 5px; height: 210px;'>
        <div style='width: 100%; height: 200px; overflow: auto; overflow-y: scroll;'>
            <?php
            $request = "SELECT * FROM reference WHERE status = 'complete' and name not like '%ncrna%' and name not like '%NONCODE%' ORDER BY name";
            $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
            while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
                $id = $row ['reference_id'];
                $key = $row ['name'];
                echo "<div style='padding:2px;width:100%;'>";
                echo "<div class='btn-group' role='group' data-toggle='tooltip' data-placement='top' title='" . number_format($row ['size'], 0, '.', ',') . " " . $row ['type'] . " sequences " . $row ['species'] . " " . $row ['description'] . "' style='width: 100%;'>";
                echo "<label data-toggle='buttons' id='$id' class='btn btn-sm btn-default' style='width:90%;' for='$id'>";
                if ($row ['type'] == 'nucleic') {
                    echo "<input type='checkbox' name='BLASTN[]' id='$id' value='$id' style='display:none;'>" . substr($key, 0, 40) . "</label>";
                } else {
                    echo "<input type='checkbox' name='BLASTP[]' id='$id' value='$id' style='display:none;'>" . substr($key, 0, 40) . "</label>";
                }
                echo "<button style='width:10%;' class='btn btn-sm btn-default' type='button' data-toggle='collapse' data-target='#collapse_$id' aria-expanded='false' aria-controls='collapse_$id'><span class='caret'></span></button>";
                echo "</div>";
                echo "<div class='collapse' id='collapse_$id' style='width:100%;'>";
                echo "<div class='card card-block' style='width:100%;'>";
                echo "<div class='input-group' style='width:100%;padding-right:2px;'>";
                echo "<span class='input-group-btn' style='width:78%;'><label data-toggle='buttons' id='label_identity_$id' class='btn btn-sm btn-default active' type='button' style='width:100%;'>identity percentage<input type='checkbox' id='checkbox_identity_$id' name='checkbox_identity_$id' style='display: none' checked></label></span>";
                echo "<input class='form-control' type='number' id='identity_$id' name='identity_$id' min='0' max='100' value='85' checked style='width:100%;height:24px;text-align: right;padding-right:0;'>";
                echo "<span class='input-group-addon' style='padding-top:0;padding-bottom:0;'>%</span>";
                echo "</div>";
                echo "<div class='input-group' style='width:100%;padding-right:2px;'>";
                echo "<span class='input-group-btn' style='width:78%;'><label data-toggle='buttons' id='label_query_cover_$id' class='btn btn-sm btn-default active' type='button' style='width:100%;'>query alignment coverage<input type='checkbox' id='checkbox_query_cover_$id' name='checkbox_query_cover_$id' style='display: none' checked></label></span>";
                echo "<input class='form-control' type='number' id='query_cover_$id' name='query_cover_$id' min='0' max='100' value='50' checked style='width:100%;height:24px;text-align: right;padding-right:0;'>";
                echo "<span class='input-group-addon' style='padding-top:0;padding-bottom:0;'>%</span>";
                echo "</div>";
                echo "<div class='input-group' style='width:100%;padding-right:2px;'>";
                echo "<span class='input-group-btn' style='width:78%;'><label data-toggle='buttons' id='label_subject_cover_$id' class='btn btn-sm btn-default active' type='button' style='width:100%;'>subject alignment coverage<input type='checkbox' id='checkbox_subject_cover_$id' name='checkbox_subject_cover_$id' style='display: none' checked></label></span>";
                echo "<input class='form-control' type='number' id='subject_cover_$id' name='subject_cover_$id' min='0' max='100' value='50' style='width:100%;height:24px;text-align: right;padding-right:0;'>";
                echo "<span class='input-group-addon' style='padding-top:0;padding-bottom:0;'>%</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>

        </div>
    </div>
</div>
<div style='width: 420px; margin: 0; padding: 0 0 5px;height: 250px;'>
    <div class="div-border-title">
       Functionnal annotation parameters <a style='float: right; margin-right: 10px;' data-toggle="tooltip"
                                             data-placement="top" href="/index.php?page=tutorial" target="_blank"
                                             title="<?php echo $tooltip_text['functional_panel']; ?>"> <img
                    src="/img/tutorial.svg"
                    style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
    </div>
    <div class="div-border" style='padding: 5px; height: 210px;'>
        <div id='functional_services_container' style='width: 100%; height: 200px; overflow: auto; overflow-y: scroll;'>
            <?php
            $services_info = get_algorithms_info();
            foreach ($services_info as $service => $info_service) {
                if($info_service ['type'] != 'coding'){continue;}
                  $key = $service;
                  $score_name = $info_service ['name'];
                  $value = $info_service ['score'];
                  $score_min = $info_service ['min'];
                  $score_max = $info_service ['max'];
                  $description = $info_service ['description'];
                  echo "<div style='padding:2px;width:100%;'>";
                  echo "<div class='btn-group' role='group' data-toggle='tooltip' data-placement='top' title='$description' style='width: 100%;'>";

                  echo "<label data-toggle='buttons' id='$key' class='btn btn-sm btn-default' for='$key' style='width:90%;'>";
                  echo "<input type=\"checkbox\" name='algorithm[]' id='$key' value='$key' style='display:none;'>$key</label>";
                  echo "<button style='width:10%;' class='btn btn-sm btn-default' type='button' data-toggle='collapse' data-target='#collapse_$key' aria-expanded='false' aria-controls='collapse_$key'><span class='caret'></span></button>";
                  echo "</div>";

                  echo "<div class='collapse' id='collapse_$key' style='width:100%;'>";
                  echo "<div class='card card-block' style='width:100%;margin:0;'>";
                  echo "<div class='input-group' style='width:100%;'>";
                  echo "<span class='input-group-btn' style='width:80%;'><label data-toggle='buttons' id='label_score_$key' class='btn btn-sm btn-default active' type='button' style='width:100%;'>$score_name<input type='checkbox' id='checkbox_score_$key' name='checkbox_score_$key' style='display: none' checked></label></span>";
                  echo "<input class='form-control' lang='en' step='0.01' type='number' id='score_$key' name='score_$key' min='$score_min' max='$score_max' value='$value' style='width:100%;height:24px;text-align: right;'>";
                  echo "</div>";
                  echo "</div>";
                  echo "</div>";

                  echo "</div>";
            }
            ?>
        </div>
    </div>
</div>

<div id='container_noncoding' style='width:100%;'>
<div style='width: 420px; margin: 0; padding: 0 5px 5px 0;height: 140px;'>
    <div class="div-border-title">
        Non-coding homology annotation parameters <a style='float: right; margin-right: 10px;' data-toggle="tooltip"
                                          data-placement="top" href="/index.php?page=tutorial" target="_blank"
                                          title="<?php echo $tooltip_text['similarity_panel']; ?>"> <img
                    src="/img/tutorial.svg"
                    style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
    </div>

    <div class="div-border" style='padding: 5px; height: 100px;'>
        <div style='width: 100%; height: 90px; overflow: auto; overflow-y: scroll;'>
            <?php
            $request = "SELECT * FROM reference WHERE status = 'complete' and ( name like '%ncrna%' or name like '%NONCODE%') ORDER BY name";
            $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
            while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
                $id = $row ['reference_id'];
                $key = $row ['name'];
                echo "<div style='padding:2px;width:100%;'>";
                echo "<div class='btn-group' role='group' data-toggle='tooltip' data-placement='top' title='" . number_format($row ['size'], 0, '.', ',') . " " . $row ['type'] . " sequences " . $row ['species'] . " " . $row ['description'] . "' style='width: 100%;'>";
                echo "<label data-toggle='buttons' id='$id' class='btn btn-sm btn-default' style='width:90%;' for='$id'>";
                if ($row ['type'] == 'nucleic') {
                    echo "<input type='checkbox' name='BLASTN[]' id='$id' value='$id' style='display:none;'>" . substr($key, 0, 40) . "</label>";
                } else {
                    echo "<input type='checkbox' name='BLASTP[]' id='$id' value='$id' style='display:none;'>" . substr($key, 0, 40) . "</label>";
                }
                echo "<button style='width:10%;' class='btn btn-sm btn-default' type='button' data-toggle='collapse' data-target='#collapse_$id' aria-expanded='false' aria-controls='collapse_$id'><span class='caret'></span></button>";
                echo "</div>";
                echo "<div class='collapse' id='collapse_$id' style='width:100%;'>";
                echo "<div class='card card-block' style='width:100%;'>";
                echo "<div class='input-group' style='width:100%;padding-right:2px;'>";
                echo "<span class='input-group-btn' style='width:78%;'><label data-toggle='buttons' id='label_identity_$id' class='btn btn-sm btn-default active' type='button' style='width:100%;'>identity percentage<input type='checkbox' id='checkbox_identity_$id' name='checkbox_identity_$id' style='display: none' checked></label></span>";
                echo "<input class='form-control' type='number' id='identity_$id' name='identity_$id' min='0' max='100' value='85' checked style='width:100%;height:24px;text-align: right;padding-right:0;'>";
                echo "<span class='input-group-addon' style='padding-top:0;padding-bottom:0;'>%</span>";
                echo "</div>";
                echo "<div class='input-group' style='width:100%;padding-right:2px;'>";
                echo "<span class='input-group-btn' style='width:78%;'><label data-toggle='buttons' id='label_query_cover_$id' class='btn btn-sm btn-default active' type='button' style='width:100%;'>query alignment coverage<input type='checkbox' id='checkbox_query_cover_$id' name='checkbox_query_cover_$id' style='display: none' checked></label></span>";
                echo "<input class='form-control' type='number' id='query_cover_$id' name='query_cover_$id' min='0' max='100' value='50' checked style='width:100%;height:24px;text-align: right;padding-right:0;'>";
                echo "<span class='input-group-addon' style='padding-top:0;padding-bottom:0;'>%</span>";
                echo "</div>";
                echo "<div class='input-group' style='width:100%;padding-right:2px;'>";
                echo "<span class='input-group-btn' style='width:78%;'><label data-toggle='buttons' id='label_subject_cover_$id' class='btn btn-sm btn-default active' type='button' style='width:100%;'>subject alignment coverage<input type='checkbox' id='checkbox_subject_cover_$id' name='checkbox_subject_cover_$id' style='display: none' checked></label></span>";
                echo "<input class='form-control' type='number' id='subject_cover_$id' name='subject_cover_$id' min='0' max='100' value='50' style='width:100%;height:24px;text-align: right;padding-right:0;'>";
                echo "<span class='input-group-addon' style='padding-top:0;padding-bottom:0;'>%</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>

        </div>
    </div>
</div>
<div style='width: 420px; margin: 0; padding: 0 0 5px;height: 140px;'>
    <div class="div-border-title">
        Non-coding functionnal annotation parameters <a style='float: right; margin-right: 10px;' data-toggle="tooltip"
                                             data-placement="top" href="/index.php?page=tutorial" target="_blank"
                                             title="<?php echo $tooltip_text['functional_panel']; ?>"> <img
                    src="/img/tutorial.svg"
                    style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
    </div>
    <div class="div-border" style='padding: 5px; height: 100px;'>
        <div id='functional_services_container' style='width: 100%; height: 90px; overflow: auto; overflow-y: scroll;'>
            <?php
            $services_info = get_algorithms_info();
            foreach ($services_info as $service => $info_service) {
                if($info_service ['type'] != 'noncoding'){continue;}
                  $key = $service;
                  $score_name = $info_service ['name'];
                  $value = $info_service ['score'];
                  $score_min = $info_service ['min'];
                  $score_max = $info_service ['max'];
                  $description = $info_service ['description'];
                  echo "<div style='padding:2px;width:100%;'>";
                  echo "<div class='btn-group' role='group' data-toggle='tooltip' data-placement='top' title='$description' style='width: 100%;'>";

                  echo "<label data-toggle='buttons' id='$key' class='btn btn-sm btn-default' for='$key' style='width:90%;'>";
                  echo "<input type=\"checkbox\" name='algorithm[]' id='$key' value='$key' style='display:none;'>$key</label>";
                  echo "<button style='width:10%;' class='btn btn-sm btn-default' type='button' data-toggle='collapse' data-target='#collapse_$key' aria-expanded='false' aria-controls='collapse_$key'><span class='caret'></span></button>";
                  echo "</div>";

                  echo "<div class='collapse' id='collapse_$key' style='width:100%;'>";
                  echo "<div class='card card-block' style='width:100%;margin:0;'>";
                  echo "<div class='input-group' style='width:100%;'>";
                  echo "<span class='input-group-btn' style='width:80%;'><label data-toggle='buttons' id='label_score_$key' class='btn btn-sm btn-default active' type='button' style='width:100%;'>$score_name<input type='checkbox' id='checkbox_score_$key' name='checkbox_score_$key' style='display: none' checked></label></span>";
                  echo "<input class='form-control' lang='en' step='0.01' type='number' id='score_$key' name='score_$key' min='$score_min' max='$score_max' value='$value' style='width:100%;height:24px;text-align: right;'>";
                  echo "</div>";
                  echo "</div>";
                  echo "</div>";

                  echo "</div>";
            }
            ?>
        </div>
    </div>
</div>
</div>
